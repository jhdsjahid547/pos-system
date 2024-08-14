export default (products) => {
    return {
        async fetch ({ page, itemsPerPage, search }) {
            return new Promise(resolve => {
                setTimeout(() => {
                    const start = (page - 1) * itemsPerPage
                    const end = start + itemsPerPage
                    const items = products.slice().filter(item => {
                        // if (search.name && !item.name.toLowerCase().includes(search.name.toLowerCase())) {
                        //     return false
                        // }
                        // if (search.barcode && !(item.barcode.toString().includes(Number(search.barcode)))) {
                        //     return false
                        // }   
                        if (search.nameOrBarcode && isNaN(search.nameOrBarcode) && !item.name.toLowerCase().includes(search.nameOrBarcode.toLowerCase())) {
                            return false
                        } else if (search.nameOrBarcode && !isNaN(search.nameOrBarcode) && !item.barcode.toString().includes(Number(search.nameOrBarcode))) {
                            return false
                        }
                        return true
                    })
                    const paginated = items.slice(start, end)

                    resolve({ items: paginated, total: items.length })
                }, 500)
            })
        },
    }
}
