<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceField;
use App\Enums\ServiceTypes;
use App\Enums\UserTypes;
use App\Models\Family;
use App\Models\Service;
use App\Models\Children;
use App\Models\User;
use App\Enums\NotificationTitle;
use App\Enums\NotificationModelTypes;
use App\Enums\NotificationType;
use Redirect;
use Auth;
use Validator;
use Mail;
use App\Mail\ServiceRequestMail;

class ServicesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    private function getServiceFields($service){
        return ServiceField::where('service_id', $service)
            ->get();
    }

    private function resortSortColumn($sort, $except) {
        $fields = ServiceField::where('sort', '>=', $sort)->whereNotIn('id', $except)->orderBy('sort')->get();

        foreach($fields as $field) {
            $field->sort = ++$sort;
            $field->save();
        }
    }

    public function index($type){
        
        $service = Service::where('id', $type)->first();

        if (!$service) return Redirect::back();

        return view('services.fields.service-table', [
            "fields" => $this->getServiceFields($type),
            "service" => $service
        ]);
    }

    public function toggleStatus($id){

        $service = Service::where('id', $id)->first();

        if (!$service) return Redirect::back();

        $service->status = $service->status == 1 ? 0 : 1;

        if ($service->save()) {
            return Redirect::back()->with(['flash_success' => "Status Updated"]);
        }
        
        return Redirect::back()->with(['flash_error' => "Something went wrong!"]);
    }

    public function create(Request $request, $type){
        if (!array_key_exists($type, ServiceTypes::LIST)) return Redirect::back();

        if ($request->isMethod('post')) {
            $request->validate([
                'field_name' => ['required', 'string', 'max:255'],
                'sort' => ['required', 'numeric', 'min:1']
            ]);

            $field = new ServiceField();
            $field->field_key = generateFieldKey($request->field_name, $type);
            $field->name = $request->field_name;
            $field->type = $request->field_type;
            $field->sort = $request->sort;
            $field->status = 1;
            $field->service_id = $type;

            if ($field->save()) {
                $this->resortSortColumn($field->sort, [$field->id]);
                return Redirect::back()->with(['flash_success' => "Congratulations!, Service field has been added."]);
            }
            
            return Redirect::back()->with(['flash_error' => "Something went wrong!"]);
        }

        $sortLastField = ServiceField::where('service_id', $type)
            ->orderBy('sort','DESC')->first();

        return view('services.fields.create', [
            "sort" => $sortLastField != null ? $sortLastField->sort + 1 : 1,
            "service_id" => $type,
            "service_name" => ServiceTypes::LIST[$type],
            "service_url" => route('services.view', $type)
        ]);
    }

    public function view(Request $request, $id){
        $field = ServiceField::where('id', $id)->first();

        if ($field == null) return Redirect::back();

        if ($request->isMethod('post')) {
            $request->validate([
                'field_name' => ['required', 'string', 'max:255'],
                'sort' => ['required', 'numeric', 'min:1']
            ]);

            $field->field_key = generateFieldKey($request->field_name, $field->service_id);
            $field->name = $request->field_name;
            $field->type = $request->field_type;
            $field->sort = $request->sort;
            $field->status = $request->status;

            if ($field->save()) {
                $this->resortSortColumn($field->sort, [$field->id]);
                return Redirect::back()->with(['flash_success' => "Congratulations!, Service field has been updated."]);
            }

            return Redirect::back()->with(['flash_error' => "Something went wrong!"]);
        }

        return view('services.fields.update', [
            "service_name" => ServiceTypes::LIST[$field->service_id],
            "service_url" => route('services.view', $field->service_id),
            "field" => $field
        ]);
    }

    public function givingTree(Request $request)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'user' => ['nullable', 'exists:users,id'],
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:500'],
                'city_id' => ['required'],
                'zip' => ['required', 'string', 'max:10'],
                'phone_no' => ['required', 'max:15'],
                'people_in_household' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ], [
                'city_id.required' => 'Please select city.',
                'phone_no.required' => 'Cell no field is required.',
            ]);

            $user_id = Auth::id();
            if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator])){
                
                if(isset($request->user)){
                    $user_id = $request->user;
                }else{
                    return Redirect::back()->with(['flash_error' => 'User is Required!']);
                }
            }
            
            $family = new Family();
            $family->user_id = $user_id;
            $family->name = $request->name;
            $family->address = $request->address;
            $family->city = $request->city_id;
            $family->state = 'WA';
            $family->zip = $request->zip;
            $family->phone_no = $request->phone_no;
            $family->people_in_household = $request->people_in_household;
            $family->email = $request->email;

            $family->save();

            if ($family->save()) {

                //Notification
                addNotification(
                    NotificationType::NEW_FAMILY_ADDED,
                    NotificationModelTypes::FAMILY,
                    $family->id,
                    str_replace(
                        ['{{name}}'],
                        [Auth::user()->name],
                        NotificationTitle::TITLE['NEW_FAMILY_ADDED']
                    ),
                    str_replace(
                        ['{{name}}'],
                        ["<a href='users/" . $user_id . "'>" . Auth::user()->name . "</a>"],
                        NotificationTitle::BODY['NEW_FAMILY_ADDED']
                    ),
                    0
                );

                //send email
                $body = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'service' => "Giving Tree Sign Up"
                ];

                Mail::to(Auth::user()->email)->send(new ServiceRequestMail($body));

                return Redirect::route('giving-tree.add-child',array('family_id' => $family->id));
            }

            return Redirect::back()->with(['flash_error' => "Something went wrong!"]);
        }

        $user = Auth::user();
        
        if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator])){
            $applicants = User::where(['role_id' => UserTypes::Applicant, 'status' => 1])->get();

            return view('services.giving-tree', [
                "user" => $user,
                "applicants" => $applicants
            ]);

        }else{            
            return view('services.giving-tree', [
                "user" => $user,
            ]);
        }
    }
    
    public function givingTreeEdit(Request $request, $id)
    {
        $family = Family::find($id);
        if($family){

            if ($request->isMethod('post')) {

                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'address' => ['required', 'string', 'max:500'],
                    'city_id' => ['required'],
                    'zip' => ['required', 'string', 'max:10'],
                    'phone_no' => ['required', 'max:15'],
                    'people_in_household' => ['required'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                ], [
                    'city_id.required' => 'Please select city.',
                    'phone_no.required' => 'Cell no field is required.',
                ]);

                // $family->user_id = Auth::user()->id;
                $family->name = $request->name;
                $family->address = $request->address;
                $family->city = $request->city_id;
                $family->state = 'WA';
                $family->zip = $request->zip;
                $family->phone_no = $request->phone_no;
                $family->people_in_household = $request->people_in_household;
                $family->email = $request->email;

                $family->save();

                if ($family->save()) {
                    return Redirect::route('giving-tree.add-child',array('family_id' => $family->id));
                }

                return Redirect::back()->with(['flash_error' => "Something went wrong!"]);
            }

            $user = Auth::user();
            return view('services.edit-giving-tree', [
                'family' => $family,
                "user" => $user
            ]);
            
        }else{
            return Redirect::back()->with(['flash_error' => "Something went wrong!"]);
        }
    }

    public function deleteField($id){
        $field = ServiceField::where('id', $id)->first();

        if ($field == null) return Redirect::back();

        if ($field->delete()) {
            return Redirect::back()->with(['flash_success' => "Congratulations!, Service field has been removed."]);
        }

        return Redirect::back()->with(['flash_error' => "Something went wrong!"]);
    }

    public function getProvinceCities(Request $request) {
        return getProvinceCities($request->code);
    }

    private function getAddChildValidationAttr($fields) {
        $arr = [];

        for($i=0; $i < count($fields['name']); $i++) {
            $arr['name.'.$i] = "Child ". ($i + 1). " name";
            $arr['age.'.$i] = "Child ". ($i + 1). " age";
            $arr['gender.'.$i] = "Child ". ($i + 1). " gender";
            $arr['color.'.$i] = "Child ". ($i + 1). " color";
            $arr['shirt_size.'.$i] = "Child ". ($i + 1). " shirt size";
            $arr['pent_size.'.$i] = "Child ". ($i + 1). " pent size";
            $arr['jacket_size.'.$i] = "Child ". ($i + 1). " jacket size";
            $arr['socks_size.'.$i] = "Child ". ($i + 1). " socks size";
            $arr['underwear_size.'.$i] = "Child ". ($i + 1). " underwear size";
            $arr['diaper_size.'.$i] = "Child ". ($i + 1). " diaper size";
            $arr['pajamas_size.'.$i] = "Child ". ($i + 1). " pajamas size";
            $arr['shoes_size.'.$i] = "Child ". ($i + 1). " shoes size";
            $arr['additional_need.'.$i] = "Child ". ($i + 1). " additional need";
            $arr['wants.'.$i] = "Child ". ($i + 1). " wants";
            $arr['school_name.'.$i] = "Child ". ($i + 1). " school name";
        }

        return $arr;
    }

    public function givingTreeAddChild(Request $request, $family_id){

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name.*' => ['required', 'string', 'max:255'],
                'age.0' => ['required', 'numeric', 'min:0', 'max:14'],
                'age.*' => ['required', 'numeric', 'min:0', 'max:18'],
                'gender.*' => ['required'],
                'color.*' => ['required'],
                'shirt_size.*' => ['required'],
                'pent_size.*' => ['required'],
                'jacket_size.*' => ['required'],
                'socks_size.*' => ['required'],
                'underwear_size.*' => ['required'],
                'diaper_size.*' => ['required'],
                'pajamas_size.*' => ['required'],
                'shoes_size.*' => ['required'],
                'additional_need.*' => ['required', 'string', 'max:255'],
                'wants.*' => ['required', 'string', 'max:255'],
                'school_name.*' => ['required', 'string', 'max:255'],
            ]);
            $validator->setAttributeNames($this->getAddChildValidationAttr($request->all())); 
            $validator->validate();

            foreach($request->name as $key => $item) {
                $model = new Children();
                $model->family_id = $request->family_id;
                $model->name = $request->name[$key];
                $model->age = $request->age[$key];
                $model->gender = $request->gender[$key];
                $model->color = $request->color[$key];
                $model->shirt_size = $request->shirt_size[$key];
                $model->pent_size = $request->pent_size[$key];
                $model->jacket_size = $request->jacket_size[$key];
                $model->socks_size = $request->socks_size[$key];
                $model->underwear_size = $request->underwear_size[$key];
                $model->diaper_size = $request->diaper_size[$key];
                $model->pajamas_size = $request->pajamas_size[$key];
                $model->shoes_size = $request->shoes_size[$key];
                $model->additional_need = $request->additional_need[$key];
                $model->wants = $request->wants[$key];
                $model->school_name = $request->school_name[$key];
                $model->save();

            }
    
            return Redirect::route('giving-tree.index')->with(['flash_success' => "Congratulations!, Family has been added."]);
        }

        return view('services.giving-tree-add-child', [
            "family_id" => $family_id
        ]);
        
    }

}
