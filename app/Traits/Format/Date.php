<?php

namespace App\Traits\Format;

trait Date
{
	public function formatDate($date, $format = 'd/m/Y')
	{
		return date($format, strtotime(str_replace('/', '-', $date)));
	}

	public function formatDateHour($date)
	{
		return $this->formatDate($date, 'd/m/Y H:i');
	}
}