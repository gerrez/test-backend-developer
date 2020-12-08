<?php

class DocumentStage
{
    public const FINISHED = 'finished';
    public const DRAFT = 'draft';
    public const CHOOSE_REGISTRATION_TYPE = 'choose-registration-type';
    public const DIY_REGISTRATION = 'diy-registration';
    public const TESTAVIVA_REGISTRATION = 'testaviva-registration';
    public const AWAITING_SIGNATURE = 'awaiting-signature';
    public const AWAITING_ADVICE_WITHOUT_BOOKING = 'meeting-booking-without-time';
    public const AWAITING_REVIEW_WITHOUT_BOOKING = 'review-booking-without-time';
    public const AWAITING_ADVICE = 'awaiting-meeting';
    public const AWAITING_REVIEW = 'awaiting-review';
    public const AWAITING_WITNESS = 'confirm-witness';
    public const AWAITING_PAYMENT = 'awaiting-payment';
    public const POST_MEETING_DRAFT = 'post-review-draft';
    public const VISIT_NOTARY = 'visit-notary';
    public const FINISHED_NOTARY = 'finished-notary';
    public const FINISHED_TESTAVIVA = 'finished-testaviva';
    public const UPDATE = 'update-recommended';
    public const FILL_OUT = 'fill-out';

    public static function getTitle($stage)
    {
        switch ($stage) {
            case DocumentStage::FILL_OUT:
                return 'Udfyld dit dokument';
            case DocumentStage::AWAITING_PAYMENT:
                return 'Køb dit dokument - vælg pakke';
            case DocumentStage::AWAITING_REVIEW:
            case DocumentStage::AWAITING_ADVICE_WITHOUT_BOOKING:
            case DocumentStage::AWAITING_ADVICE:
                return 'Evt. juridisk hjælp';
            case DocumentStage::CHOOSE_REGISTRATION_TYPE:
                return 'Tinglysning';
            case DocumentStage::VISIT_NOTARY:
                return 'Notar';
            case DocumentStage::AWAITING_SIGNATURE:
                return 'Underskrift';
            case DocumentStage::FINISHED:
                return 'Juridisk gyldigt';
        }
        return $stage;
    }


    /**
     * @param string $stage
     * @param array $states
     * @return bool
     */
    public static function isStageReached($stage, $states)
    {
        switch ($stage) {
            case self::FILL_OUT:
                return in_array(DocumentState::DRAFT, $states, true);
            case self::AWAITING_PAYMENT:
                return in_array(DocumentState::WAITING_FOR_PAYMENT, $states, true);
            case self::AWAITING_REVIEW:
            case self::AWAITING_ADVICE_WITHOUT_BOOKING:
            case self::AWAITING_REVIEW_WITHOUT_BOOKING:
            case self::AWAITING_ADVICE:
                return in_array(DocumentState::WAITING_FOR_MEETING, $states, true);
            case self::CHOOSE_REGISTRATION_TYPE:
                return in_array(DocumentState::WAITING_FOR_REGISTRATION, $states, true);
            case self::AWAITING_SIGNATURE:
                return in_array(DocumentState::WAITING_FOR_SIGNATURE, $states, true);
            case self::VISIT_NOTARY:
                return in_array(DocumentState::WAITING_FOR_CONFIRMATION, $states, true);
            case self::FINISHED:
                return in_array(DocumentState::SIGNED, $states, true);
        }

        return false;
    }


    /**
     * @param string $stage
     * @param boolean|string $state
     * @return bool
     */
    public static function isStageActive($stage, $state)
    {
        switch ($stage) {
            case self::FILL_OUT:
                return DocumentState::DRAFT === $state;
            case self::AWAITING_PAYMENT:
                return DocumentState::WAITING_FOR_PAYMENT === $state;
            case self::AWAITING_REVIEW:
            case self::AWAITING_ADVICE_WITHOUT_BOOKING:
            case self::AWAITING_REVIEW_WITHOUT_BOOKING:
            case self::AWAITING_ADVICE:
                return DocumentState::WAITING_FOR_MEETING === $state;
            case self::CHOOSE_REGISTRATION_TYPE:
                return DocumentState::WAITING_FOR_REGISTRATION === $state;
            case self::AWAITING_SIGNATURE:
                return DocumentState::WAITING_FOR_SIGNATURE === $state;
            case self::VISIT_NOTARY:
                return DocumentState::WAITING_FOR_CONFIRMATION === $state;
            case self::FINISHED:
                return DocumentState::SIGNED === $state;
        }

        return false;
    }
}
