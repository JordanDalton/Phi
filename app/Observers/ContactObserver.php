<?php

namespace App\Observers;

use App\Contact;

class ContactObserver
{
    public function creating(Contact $contact)
    {
        \Log::info('Contact was created');

        // You could use this to fire an event that would send an email.
    }
}