function formatDate(createdAt) {
    const createdAtDate = new Date(createdAt);

    const timezoneOffset = 3 * 60;
    const now = new Date();
    now.setMinutes(now.getMinutes() + now.getTimezoneOffset() + timezoneOffset);

    const msPerDay = 24 * 60 * 60 * 1000;
    const daysDifference = Math.floor((now - createdAtDate) / msPerDay);

    let formattedDate;

    if (daysDifference === 0) {
        formattedDate = 'Сегодня в ' + createdAtDate.getHours().toString().padStart(2, '0') + ':' + createdAtDate.getMinutes().toString().padStart(2, '0');
    } else if (daysDifference === 1) {
        formattedDate = 'Вчера в ' + createdAtDate.getHours().toString().padStart(2, '0') + ':' + createdAtDate.getMinutes().toString().padStart(2, '0');
    } else {
        const monthNames = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];
        formattedDate = createdAtDate.getDate() + ' ' + monthNames[createdAtDate.getMonth()] + ' в ' + createdAtDate.getHours().toString().padStart(2, '0') + ':' + createdAtDate.getMinutes().toString().padStart(2, '0');
    }

    return formattedDate;
}

function useSearchParams() {
    return new URL(document.location).searchParams;
}