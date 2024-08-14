const formatted = timestamp => {
    const dateObj = new Date(timestamp);
    return dateObj.toISOString().split('T')[0];
};
export default invoice => {
    return {
        async fetch ({ page, itemsPerPage, search }) {
            return new Promise(resolve => {
                setTimeout(() => {
                    const start = (page - 1) * itemsPerPage
                    const end = start + itemsPerPage
                    const items = invoice.slice().filter(item => {
                        if (search.invoiceId && item.id !== Number(search.invoiceId)) {
                            return false
                        }
                        if (search.range && search.range.length >= 2  && !(formatted(item.created_at) >= formatted(search.range[0]) && formatted(item.created_at) <= formatted(search.range.at(-1)))) {
                            return false
                        }
                        return !(search.range && search.range.length === 1 && !(formatted(item.created_at) >= formatted(search.range)));
                        /*if (search.range &&  search.range.length === 1 && !(formatted(item.created_at) >= formatted(search.range))) {
                            return false
                        }*/
                    })
                    const paginated = items.slice(start, end)

                    resolve({ items: paginated, total: items.length })
                }, 500)
            })
        },
    }
}
