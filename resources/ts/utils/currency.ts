export const $currency = {
    format(value: number, currency_code: string = 'PHP') {
        const formatter = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: currency_code,
            minimumFractionDigits: 2,
        });

        return formatter.format(value);
    },
}
