<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\EventBooking;
use App\Models\EventTimeSlot;
use App\Models\UserInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserVerificationMail extends Mailable {
    use Queueable, SerializesModels;

    private UserInfo $userInfo;
    private Event $event;
    private EventBooking $eventBooking;
    private EventTimeSlot $eventTimeSlot;
    private string $verificationLink;
    private string $bookingLink;

    public function __construct(Event $event, UserInfo $userInfo, EventBooking $eventBooking, EventTimeSlot $eventTimeSlot) {
        $this->userInfo = $userInfo;
        $this->event = $event;
        $this->eventBooking = $eventBooking;
        $this->eventTimeSlot = $eventTimeSlot;
        $this->verificationLink = url('/user-info/' . $this->userInfo->id . '/confirm?code=' . $this->userInfo->verification_code);
        $this->bookingLink = url('/booking/' . $this->eventBooking->uuid);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope {
        return new Envelope(
            subject: "🎉 Potvrzení registrace na akci: {$this->event->title}"
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content {
        return new Content(
            markdown: 'emails.user.verification',
            with: [
                'userInfo' => $this->userInfo,
                'event' => $this->event,
                'eventBooking' => $this->eventBooking,
                'eventTimeSlot' => $this->eventTimeSlot,
                'verificationLink' => $this->verificationLink,
                'bookingLink' => $this->bookingLink,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array {
        return [];
    }
}
