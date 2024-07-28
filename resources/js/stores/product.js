export default (desserts) => {
    return {
        async fetch ({ page, itemsPerPage, search }) {
            return new Promise(resolve => {
                setTimeout(() => {
                    const start = (page - 1) * itemsPerPage
                    const end = start + itemsPerPage
                    const items = desserts.slice().filter(item => {
                        return !(search.name && !item.name.toLowerCase().includes(search.name.toLowerCase()));
                    })

                    const paginated = items.slice(start, end)

                    resolve({ items: paginated, total: items.length })
                }, 500)
            })
        },
    }
}
