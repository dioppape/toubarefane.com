<?php
namespace Toubarefane\SiteBundle\Entity;
class Contact {
public function isSubjectValid()
{
    return (!empty($this->subject));
}
}