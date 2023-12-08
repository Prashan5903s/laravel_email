<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpImap\Mailbox as ImapMailbox;


class EmailController extends Controller
{
    public function fetchAndSaveEmails()
    {

        // Gmail IMAP settings
        $mailbox = new ImapMailbox('{imap.gmail.com:993/imap/ssl}INBOX', 'chaubeyprashant498@gmail.com', 'oykp dnba fvqv tekb');


        // Search for new emails
        $emails = $mailbox->searchMailbox('UNSEEN');

        foreach ($emails as $email) {
            // Parse relevant information
            $subject = $email->subject;
            $from_email = $email->fromAddress;
            $body = $email->textHtml; // or $email->textPlain for plain text
            $date_received = $email->date;

            // Insert into database
            // (Make sure to use Eloquent or query builder with prepared statements to prevent SQL injection)
            DB::table('emails')->insert([
                'subject' => $subject,
                'from_email' => $from_email,
                'body' => $body,
                'date_received' => $date_received,
            ]);
        }

        return response()->json(['message' => 'Emails fetched and saved successfully']);
    }
}
