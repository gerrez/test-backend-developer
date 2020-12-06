<?php

class DocumentState
{
    public const DRAFT = 'draft';
    public const WAITING_FOR_SIGNATURE = 'waiting-for-signature';
    public const WAITING_FOR_REGISTRATION = 'waiting-for-registration';
    public const WAITING_FOR_CONFIRMATION = 'waiting-for-confirmation';
    public const WAITING_FOR_TESTAVIVA_REGISTRATION = 'waiting-for-testaviva-registration';
    public const WAITING_FOR_MEETING = 'waiting-for-meeting';
    public const WAITING_FOR_PAYMENT = 'waiting-for-payment';
    public const UPDATE_RECOMMENDED = 'update-recommended';
    public const SIGNED = 'signed';

    public static function getCallToActions($currentState)
    {
        $buttons = [];

        switch ($currentState) {
            default:
                $buttons[] = [
                    'title' => 'Begin draft',
                    'query' => [
                        'next_state' => DocumentState::DRAFT,
                    ],
                ];
                break;
            case DocumentState::DRAFT:
                $buttons[] = [
                    'title' => 'Finish draft',
                    'query' => [
                        'next_state' => DocumentState::WAITING_FOR_PAYMENT,
                    ],
                ];
                break;
            case DocumentState::WAITING_FOR_PAYMENT:
                $buttons[] = [
                    'title' => 'Edit document',
                    'query' => [
                        'next_state' => DocumentState::DRAFT,
                    ],
                ];
                $buttons[] = [
                    'title' => 'Purchase DIY',
                    'query' => [
                        'next_state' => DocumentState::WAITING_FOR_REGISTRATION,
                        'purchase_type' => PurchaseType::DIGITAL_DOCUMENT_BASIS,
                    ],
                ];
                $buttons[] = [
                    'title' => 'Purchase Advice',
                    'query' => [
                        'next_state' => DocumentState::WAITING_FOR_MEETING,
                        'purchase_type' => PurchaseType::DIGITAL_DOCUMENT_ADVICE,
                    ],
                ];
                break;
            case DocumentState::WAITING_FOR_MEETING:
                $buttons[] = [
                    'title' => 'Edit document',
                    'query' => [
                        'next_state' => DocumentState::DRAFT,
                    ],
                ];
                $buttons[] = [
                    'title' => 'Book meeting',
                    'query' => [
                        'next_state' => DocumentState::WAITING_FOR_MEETING,
                        'meeting' => PurchaseType::DIGITAL_DOCUMENT_ADVICE,
                    ],
                ];
                $buttons[] = [
                    'title' => 'Attend meeting',
                    'query' => [
                        'next_state' => DocumentState::WAITING_FOR_REGISTRATION,
                    ],
                ];
                break;
            case DocumentState::WAITING_FOR_REGISTRATION:
                $buttons[] = [
                    'title' => 'Edit document',
                    'query' => [
                        'next_state' => DocumentState::DRAFT,
                    ],
                ];
                $buttons[] = [
                    'title' => 'Select registration',
                    'query' => [
                        'next_state' => DocumentState::WAITING_FOR_SIGNATURE,
                    ],
                ];
                break;
            case DocumentState::WAITING_FOR_SIGNATURE:
                $buttons[] = [
                    'title' => 'Sign document',
                    'query' => [
                        'next_state' => DocumentState::WAITING_FOR_CONFIRMATION,
                    ],
                ];
                break;
            case DocumentState::WAITING_FOR_CONFIRMATION:
                $buttons[] = [
                    'title' => 'Attend notary',
                    'query' => [
                        'next_state' => DocumentState::SIGNED,
                    ],
                ];
                break;
            case DocumentState::SIGNED:
                break;
        }

        return $buttons;
    }
}
