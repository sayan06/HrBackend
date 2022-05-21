<?php

namespace App\Hr\Mail\Contracts;

interface MailMessageInterface
{
    public function getMailFrom(): string;

    public function getMailFromName(): string;

    public function getReplyTo(): string;

    public function getReplyToName(): string;

    public function getSubject(): string;

    public function renderBody(): string;
}
