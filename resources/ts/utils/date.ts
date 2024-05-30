import moment from "moment";

export const $date = {
    formatDate(date: string, format = null) {
        let formatted_date = date;
        if (format) {
            formatted_date = moment(String(date)).format(format);
        } else {
            formatted_date = moment(String(date)).format(
                "MMMM DD, YYYY  hh:mm A"
            );
        }

        return formatted_date;
    },
    daysLeft(date: Date) {
        const dateFormatted = new Date(date);
        const seconds = Math.floor((dateFormatted - new Date()) / 1000);

        return Math.floor(seconds / (3600 * 24));
    },
}
