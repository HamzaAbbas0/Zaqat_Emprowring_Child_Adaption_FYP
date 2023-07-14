<?php

namespace App\Enums;

abstract class NotificationTitle
{
    const TITLE = [
        'NEW_REQUEST' => '{{name}} posted a new request.',
        'REQUEST_DOCUMENTS' => 'Please upload more documents about application',
        'DOCUMENT_UPLOADED' => '{{name}} uploaded new document for application',
        'REQUEST_APPROVED' => 'Your Request has been approved',
        'REQUEST_REJECTED' => 'Your Request has been rejected',
        'REQUEST_COMPLETED' => 'Your Request has been completed',
        'REQUEST_TO_HELP' => 'Your request to help has been submitted',
        'REQUEST_TO_HELP_RECEIVED' => '{{name}} wants to help an application',
        'REQUEST_TO_HELP_FAMILY' => 'You submitted a request to help a family',
        'REQUEST_TO_HELP_FAMILY_RECEIVED' => '{{name}} wants to help a family',
        'REQUEST_TO_HELP_CHILDRENS' => 'You submitted a request to adopt child(s)',
        'REQUEST_TO_HELP_CHILDRENS_RECEIVED' => '{{name}} wants to adopt child(s)',
        'NEW_FAMILY_ADDED' => '{{name}} added new family for adoption'
    ];

    const BODY = [
        'NEW_REQUEST' => '{{name}} posted a new request.',
        'REQUEST_DOCUMENTS' => 'Please upload more documents about application',
        'DOCUMENT_UPLOADED' => '{{name}} uploaded new document for application',
        'REQUEST_APPROVED' => 'Your Request has been approved',
        'REQUEST_REJECTED' => 'Your Request has been rejected',
        'REQUEST_COMPLETED' => 'Your Request has been completed',
        'REQUEST_TO_HELP' => 'Your request to help has been submitted',
        'REQUEST_TO_HELP_RECEIVED' => '{{name}} wants to help an application',
        'REQUEST_TO_HELP_FAMILY' => 'You submitted a request to help a family',
        'REQUEST_TO_HELP_FAMILY_RECEIVED' => '{{name}} wants to help a family',
        'REQUEST_TO_HELP_CHILDRENS' => 'You submitted a request to adopt child(s)',
        'REQUEST_TO_HELP_CHILDRENS_RECEIVED' => '{{name}} wants to adopt child(s)',
        'NEW_FAMILY_ADDED' => '{{name}} added new family for adoption'
    ];
}