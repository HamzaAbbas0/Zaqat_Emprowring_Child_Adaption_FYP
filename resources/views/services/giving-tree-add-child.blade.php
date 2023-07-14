@extends('layouts.app')

@section('content')

<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>Giving Tree Sign Up</h1>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ route('history.index') }}">Requests</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ route('requests.create') }}">Add New Request</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Giving Tree Sign Up</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="contentPageWhiteBG mb-5">
    <div class="row justify-content-center mx-3">
        <div class="col-lg-12 col-md-12">
            <div class="card shadow givingTreePage mb-4">
                <div class="card-header" id="cardHeader">
                    <a href="{{ route('giving-tree.edit', $family_id) }}"><i class="fa fa-backward"></i></a>
                </div>
                <div class="card-body">
                    <div class="donationRequestForm newRequestForm">
                        <form name="givingTreeForm" action="" method="POST">
                            @csrf

                            @if(session()->has('flash_error'))
                                <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                            @endif
                            @if(session()->has('flash_success'))
                                <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                            @endif
                            
                            <input type="hidden" name="family_id" value="{{ $family_id }}" />

                            <div class="childInfoSection">
                                <?php
                                    $childCount = 1;
                                    if (old('name')) {
                                        $childCount = count(old('name'));
                                    }
                                ?>
                                @for ($i = 0; $i < $childCount; $i++)
                                <div id="card-body">
                                    <div class="card-header">
                                        <h2 id="givingTreePageTitle" class="ppppppp">Child Information {{ $i + 1 }}</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="formLabel">Childs Name</div>
                                                <div class="formField">
                                                    <input type="text" name="name[]" value="{{  old('name')[$i] ?? '' }}" class="form-control @error('name.'.$i) is-invalid @enderror" />
                                                    @error("name.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="formLabel">Age <span class="labelMessage">Age Must Be 0-{{ $i == 0 ? "14" : "18" }}</span></div>
                                                <div class="formField">
                                                    <input type="number" value="{{ old('age')[$i] ?? '' }}" max="14" name="age[]" class="age-limit form-control @error('age.'.$i) is-invalid @enderror" />
                                                    @error("age.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="formLabel">Gender</div>
                                                <div class="formField customSelectBox">
                                                    <select class="form-select @error('gender.'.$i) is-invalid @enderror" name="gender[]">
                                                        <option value="">Select</option>
                                                        @foreach(\App\Enums\Dropdowns::GENDER as $gender)
                                                            <option value="{{ $gender }}" {{ ((old('gender')[$i] ?? '') == $gender ? "selected":"") }}>{{ $gender }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error("gender.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="formLabel">Favorite Color</div>
                                                <div class="formField customSelectBox">
                                                    <input value="{{ (old('color')[$i] ?? '') }}" type="text" class="form-control @error('color.'.$i) is-invalid @enderror" name="color[]" />
                                                    
                                                    <!-- <select class="form-select @error('color.'.$i) is-invalid @enderror" name="color[]">
                                                        <option value="">Select</option>
                                                        @foreach(\App\Enums\Dropdowns::COLOR as $color)
                                                            <option value="{{ $color }}" {{ ((old('color')[$i] ?? '') == $color ? "selected":"") }}>{{ $color }}</option>
                                                        @endforeach
                                                    </select> -->
                                                    @error("color.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="formLabel">Shirt Size</div>
                                                <div class="formField customSelectBox">
                                                    <input value="{{ (old('shirt_size')[$i] ?? '') }}" type="text" class="form-control @error('shirt_size.'.$i) is-invalid @enderror" name="shirt_size[]" />
                                                    
                                                    <!-- <select class="form-select @error('shirt_size.'.$i) is-invalid @enderror" name="shirt_size[]">
                                                        <option value="">Select</option>
                                                        @foreach(\App\Enums\Dropdowns::SHIRTSIZE as $shirt_size)
                                                            <option value="{{ $shirt_size }}" {{ ((old('shirt_size')[$i] ?? '') == $shirt_size ? "selected":"") }}>{{ $shirt_size }}</option>
                                                        @endforeach
                                                    </select> -->
                                                    @error("shirt_size.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="formLabel">Pant Size</div>
                                                <div class="formField customSelectBox">
                                                    <input value="{{ (old('pent_size')[$i] ?? '') }}" type="text" class="form-control @error('pent_size.'.$i) is-invalid @enderror" name="pent_size[]" />
                                                    
                                                    <!-- <select class="form-select @error('pent_size.'.$i) is-invalid @enderror" name="pent_size[]">
                                                        <option value="">Select</option>
                                                        @foreach(\App\Enums\Dropdowns::SHIRTSIZE as $pent_size)
                                                            <option value="{{ $pent_size }}" {{ ((old('pent_size')[$i] ?? '') == $pent_size ? "selected":"") }}>{{ $pent_size }}</option>
                                                        @endforeach
                                                    </select> -->
                                                    @error("pent_size.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="formLabel">Jacket Size</div>
                                                <div class="formField customSelectBox">
                                                    <input value="{{ (old('jacket_size')[$i] ?? '') }}" type="text" class="form-control @error('jacket_size.'.$i) is-invalid @enderror" name="jacket_size[]" />
                                                    
                                                    <!-- <select class="form-select @error('jacket_size.'.$i) is-invalid @enderror" name="jacket_size[]">
                                                        <option value="">Select</option>
                                                        @foreach(\App\Enums\Dropdowns::SHIRTSIZE as $jacket_size)
                                                            <option value="{{ $jacket_size }}" {{ ((old('jacket_size')[$i] ?? '') == $jacket_size ? "selected":"") }}>{{ $jacket_size }}</option>
                                                        @endforeach
                                                    </select> -->
                                                    @error("jacket_size.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="formLabel">Socks Size</div>
                                                <div class="formField customSelectBox">
                                                    <input value="{{ (old('socks_size')[$i] ?? '') }}" type="text" class="form-control @error('socks_size.'.$i) is-invalid @enderror" name="socks_size[]" />
                                                    
                                                    <!-- <select class="form-select @error('socks_size.'.$i) is-invalid @enderror" name="socks_size[]">
                                                        <option value="">Select</option>
                                                        @foreach(\App\Enums\Dropdowns::SOCKSSIZE as $socks_size)
                                                            <option value="{{ $socks_size }}" {{ ((old('socks_size')[$i] ?? '') == $socks_size ? "selected":"") }}>{{ $socks_size }}</option>
                                                        @endforeach
                                                    </select> -->
                                                    @error("socks_size.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="formLabel">Underwear Size</div>
                                                <div class="formField customSelectBox">
                                                    <input value="{{ (old('underwear_size')[$i] ?? '') }}" type="text" class="form-control @error('underwear_size.'.$i) is-invalid @enderror" name="underwear_size[]" />
                                                    
                                                    <!-- <select class="form-select @error('underwear_size.'.$i) is-invalid @enderror" name="underwear_size[]">
                                                        <option value="">Select</option>
                                                        @foreach(\App\Enums\Dropdowns::SHIRTSIZE as $underwear_size)
                                                            <option value="{{ $underwear_size }}" {{ ((old('underwear_size')[$i] ?? '') == $underwear_size ? "selected":"") }}>{{ $underwear_size }}</option>
                                                        @endforeach
                                                    </select> -->
                                                    @error("underwear_size.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="formLabel">Diaper Size</div>
                                                <div class="formField customSelectBox">
                                                    <input value="{{ (old('diaper_size')[$i] ?? '') }}" type="text" class="form-control @error('diaper_size.'.$i) is-invalid @enderror" name="diaper_size[]" />
                                                    
                                                    <!-- <select class="form-select @error('diaper_size.'.$i) is-invalid @enderror" name="diaper_size[]">
                                                        <option value="">Select</option>
                                                        @foreach(\App\Enums\Dropdowns::DIAPERSIZE as $diaper_size)
                                                            <option value="{{ $diaper_size }}" {{ ((old('diaper_size')[$i] ?? '') == $diaper_size ? "selected":"") }}>{{ $diaper_size }}</option>
                                                        @endforeach
                                                    </select> -->
                                                    @error("diaper_size.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="formLabel">Pajamas Size</div>
                                                <div class="formField customSelectBox">
                                                    <input value="{{ (old('pajamas_size')[$i] ?? '') }}" type="text" class="form-control @error('pajamas_size.'.$i) is-invalid @enderror" name="pajamas_size[]" />
                                                    
                                                    <!-- <select class="form-select @error('pajamas_size.'.$i) is-invalid @enderror" name="pajamas_size[]">
                                                        <option value="">Select</option>
                                                        @foreach(\App\Enums\Dropdowns::SHIRTSIZE as $pajamas_size)
                                                            <option value="{{ $pajamas_size }}" {{ ((old('pajamas_size')[$i] ?? '') == $pajamas_size ? "selected":"") }}>{{ $pajamas_size }}</option>
                                                        @endforeach
                                                    </select> -->
                                                    @error("pajamas_size.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="formLabel">Shoes Size</div>
                                                <div class="formField customSelectBox">
                                                    <input value="{{ (old('shoes_size')[$i] ?? '') }}" type="text" class="form-control @error('shoes_size.'.$i) is-invalid @enderror" name="shoes_size[]" />
                                                    
                                                    <!-- <select class="form-select @error('shoes_size.'.$i) is-invalid @enderror" name="shoes_size[]">
                                                        <option value="">Select</option>
                                                        @foreach(\App\Enums\Dropdowns::SOCKSSIZE as $shoes_size)
                                                            <option value="{{ $shoes_size }}" {{ ((old('shoes_size')[$i] ?? '') == $shoes_size ? "selected":"") }}>{{ $shoes_size }}</option>
                                                        @endforeach
                                                    </select> -->
                                                    @error("shoes_size.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="formLabel">Additional Need?</div>
                                                <div class="formField">
                                                    <textarea id="" rows="2" name="additional_need[]" class="form-control @error('additional_need.'.$i) is-invalid @enderror">{{  old('additional_need')[$i] ?? '' }}</textarea>
                                                    @error("additional_need.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="formLabel">Wants</div>
                                                <div class="formField">
                                                    <textarea id="" rows="2" name="wants[]" class="form-control @error('wants.'.$i) is-invalid @enderror">{{  old('wants')[$i] ?? '' }}</textarea>
                                                    @error("wants.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="formLabel">Please List The School That You Are Enrolled In</div>
                                                <div class="formField">
                                                    <select class="form-select @error('school_name.'.$i) is-invalid @enderror" name="school_name[]">
                                                        <option value="">Select</option>
                                                        <option value="Belfair Elementary" {{ ((old('school_name')[$i] ?? '') == "Belfair Elementary" ? "selected" : "") }}>Belfair Elementary</option>
                                                        <option value="Grapeview Elementary" {{ ((old('school_name')[$i] ?? '') == "Grapeview Elementary" ? "selected" : "") }}>Grapeview Elementary</option>
                                                        <option value="Hawkins Middle School" {{ ((old('school_name')[$i] ?? '') == "Hawkins Middle School" ? "selected" : "") }}>Hawkins Middle School</option>
                                                        <option value="Head Start" {{ ((old('school_name')[$i] ?? '') == "Head Start" ? "selected" : "") }}>Head Start</option>
                                                        <option value="Middle School" {{ ((old('school_name')[$i] ?? '') == "Middle School" ? "selected" : "") }}>Middle School</option>
                                                        <option value="North Mason High School" {{ ((old('school_name')[$i] ?? '') == "North Mason High School" ? "selected" : "") }}>North Mason High School</option>
                                                        <option value="Sand Hill Elementary" {{ ((old('school_name')[$i] ?? '') == "Sand Hill Elementary" ? "selected" : "") }}>Sand Hill Elementary</option>
                                                        <option value="Not in School Yet" {{ ((old('school_name')[$i] ?? '') == "Not in School Yet" ? "selected" : "") }}>Not in School Yet</option>
                                                        <option value="Other" {{ ((old('school_name')[$i] ?? '') == "Other" ? "selected" : "") }}>Other</option>
                                                        <option value="Home School" {{ ((old('school_name')[$i] ?? '') == "Home School" ? "selected" : "") }}>Home School</option>
                                                    </select>
                                                    @error("school_name.".$i)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-start">
                                            <div class="col-lg-9">
                                                <div class="childBTN">
                                                    <a href="javascript:void(0)" id="addChildBTN" onclick="cloneForm()">Add Child</a>
                                                    <a href="javascript:void(0)" class="removeChildBTN" id="removeChildBTN" style="display:none;" onclick="removeChildForm(this)">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endfor

                                <div id="givingTreeChildForm"></div>
                            </div>
                            <div class="formFieldBTN" id="givingTreeSubmitBTN"><a href="javascript:document.givingTreeForm.submit()">Submit</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('footer-scripts')
<script>
    $(document).on("change", ".select-state", function(e) {
        const code = e.target.value
        const url = "{{ route('services.get.province.cities') }}"
        var html = `<option value="">Select City</option>`;

        $.ajax({
            url,
            type: 'GET',
            data: { code },
            success: function (response){
                response.map(row => {
                    html += `<option value="${row.id}">${row.local_name}</option>`
                })
                $('#select-city').html(html)
            }
        });

    });
</script>

@endsection