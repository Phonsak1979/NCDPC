<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('DateThai')) {
    /**
     * Format a date/time into Thai date string (B.E.)
     * Example: 2025-12-14 -> 14 ธันวาคม 2568
     *
     * @param mixed $date Any value accepted by strtotime(), UNIX timestamp, or DateTimeInterface
     */
    function DateThai($date): string
    {
        if ($date instanceof DateTimeInterface) {
            $timestamp = $date->getTimestamp();
        } elseif (is_int($date) || (is_string($date) && ctype_digit($date))) {
            $timestamp = (int) $date;
        } else {
            $timestamp = strtotime((string) $date);
        }

        if (! $timestamp) {
            return '-';
        }

        $thaiMonths = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม',
        ];

        $day = (int) date('j', $timestamp);
        $month = (int) date('n', $timestamp);
        $yearBE = (int) date('Y', $timestamp) + 543;

        return $day . ' ' . ($thaiMonths[$month] ?? '') . ' ' . $yearBE;
    }
}
