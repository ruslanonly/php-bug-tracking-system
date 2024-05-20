<?php
    function formatDate(string $createdAt) {

        $createdAtDateTime = new DateTime($createdAt);

        $now = new DateTime('now', new DateTimeZone('+0300'));

        $interval = $now->diff($createdAtDateTime);
        $daysDifference = $interval->days;

        if ($daysDifference == 0) {
            $formattedDate = 'Сегодня в ' . $createdAtDateTime->format('H:i');
        } elseif ($daysDifference == 1) {
            $formattedDate = 'Вчера в ' . $createdAtDateTime->format('H:i');
        } else {
            $formattedDate = $createdAtDateTime->format('j F') . ' в ' . $createdAtDateTime->format('H:i');
        }

        return $formattedDate;
    }
?>