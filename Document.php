<?php

include 'DocumentState.php';
include 'DocumentStage.php';
include 'PurchaseType.php';

class Document
{
    /**
     * On page load, this constructor will set the right state, mark a document as payed and a meeting as held,
     * depending on the query parameter.
     */
    public function __construct()
    {

        if (isset($_GET['next_state'])) {
            if ($this->getCurrentStatus() !== $_GET['next_state']) {
                $states = file_get_contents("states.db");
                if ($_GET['next_state'] === DocumentState::WAITING_FOR_PAYMENT && $this->isPayed()) {
                    $states .= $this->getPreviousStatus() . ";";
                } else {
                    $states .= $_GET['next_state'] . ";";
                }
                file_put_contents('states.db', $states);
            }
        }
        if (isset($_GET['purchase_type'])) {
            file_put_contents('payed.db', $_GET['purchase_type']);
        }
        if (isset($_GET['meeting'])) {
            file_put_contents('meeting.db', 'completed');
        }
    }

    /**
     * Whether or not the document has been payed.
     *
     * @return bool
     */
    private function isPayed()
    {
        return (bool) file_get_contents('payed.db');
    }

    /**
     * If the document has been payed, this will return the purchase type (See PurchaseType.php).
     *
     * @return false|string
     */
    private function getPurchaseType()
    {
        return file_get_contents('payed.db');
    }

    /**
     * Whether or not a time has been booked for the document.
     *
     * @return bool
     */
    private function haveBooking()
    {
        return (bool) file_get_contents('meeting.db');
    }

    /**
     * Whether or not a booking was completed.
     *
     * @return bool
     */
    private function haveHadMeeting()
    {
        $meeting = file_get_contents('meeting.db');

        return $meeting === 'completed';
    }

    /**
     * Will return an array of the states (see DocumentState.php) the document have been through.
     *
     * @return string[]
     */
    public function getStates()
    {
        $states = file_get_contents("states.db");
        $states = explode(';', $states);
        return array_filter($states);
    }

    /**
     * Get the previous state.
     *
     * @return string
     */
    public function getPreviousStatus()
    {
        $states = $this->getStates();
        return $states[count($states) - 2];
    }

    /**
     * Get the current state.
     *
     * @return string
     */
    public function getCurrentStatus()
    {
        $states = $this->getStates();
        return end($states);
    }

    /**
     * @return array
     *   The array returned from this method must consists of items with the following keys:
     *   - stage: The title of the stage
     *   - reached: Whether the stage has been reached, either now or previously
     *   - active: Whether the stage is active
     *
     *  There should only ever be one active stage.
     *
     *  Example:
     *  [
     *      'stage' => 'draft',
     *      'reached' => true,
     *      'active' => true,
     *  ],
     */
    public function getProgress()
    {
        // @TODO: This should be replaced by your code.
        return array_map(function ($stage) {
            if (is_array($stage)) {
                $stage = array_shift($stage);
            }
            return [
                'stage' => $stage,
                'reached' => false,
                'active' => false,
            ];
        }, $this->getStages());
    }

    /**
     * The possible stages for the document.
     *
     * @return array
     */
    public function getStages()
    {
        return [
            DocumentStage::FILL_OUT,
            DocumentStage::AWAITING_PAYMENT,
            [
                DocumentStage::AWAITING_REVIEW,
                DocumentStage::AWAITING_ADVICE,
                DocumentStage::AWAITING_ADVICE_WITHOUT_BOOKING,
                DocumentStage::AWAITING_REVIEW_WITHOUT_BOOKING,
            ],
            DocumentStage::CHOOSE_REGISTRATION_TYPE,
            DocumentStage::AWAITING_SIGNATURE,
            DocumentStage::VISIT_NOTARY,
            [
                DocumentStage::FINISHED,
                DocumentStage::FINISHED_NOTARY,
                DocumentStage::FINISHED_TESTAVIVA,
            ]
        ];
    }
}
