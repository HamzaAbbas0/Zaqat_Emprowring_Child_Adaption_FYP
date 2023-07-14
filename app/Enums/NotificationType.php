<?php

namespace App\Enums;

abstract class NotificationType
{
    const NEW_REQUEST = 'new_request';
    const REQUEST_DOCUMENTS = 'request_documents';
    const DOCUMENT_UPLOADED = 'document_uploaded';
    const REQUEST_APPROVED = 'request_approved';
    const REQUEST_REJECTED = 'request_rejected';
    const REQUEST_COMPLETED = 'request_completed';
    const REQUEST_TO_HELP = 'request_to_help';
    const REQUEST_TO_HELP_RECEIVED = 'request_to_help_received';
    const REQUEST_TO_HELP_FAMILY = 'request_to_help_family';
    const REQUEST_TO_HELP_FAMILY_RECEIVED = 'request_to_help_family_received';
    const REQUEST_TO_HELP_CHILDRENS = 'request_to_help_childrens';
    const REQUEST_TO_HELP_CHILDRENS_RECEIVED = 'request_to_help_childrens_received';
    const NEW_FAMILY_ADDED = 'new_family_added';
}