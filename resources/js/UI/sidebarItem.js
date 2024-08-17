import {
    CircleIcon,
    DashboardIcon,
    ListIcon,
    ShoppingCartIcon,
    CalculatorIcon,
    MenuOrderIcon
} from 'vue-tabler-icons'
export const sidebarItem = [
    { header: 'Admin Panel' },
    {
        title: 'Dashboard',
        icon: DashboardIcon,
        name: 'dashboard.index'
    },
    {
        title: 'Order',
        icon: MenuOrderIcon,
        name: 'orders',
        children: [
            {
                title: 'Pos',
                icon: CircleIcon,
                name: 'orders.create'
            },
            {
                title: 'List',
                icon: CircleIcon,
                name: 'orders.index'
            },
        ]
    },
    {
        title: 'Category',
        icon: ListIcon,
        name: 'categories.index'
    },
    {
        title: 'Product',
        icon: ShoppingCartIcon,
        name: 'products.index'
    },
    {
        title: 'Tax/Discount',
        icon: CalculatorIcon,
        name: 'tax-or-discounts.index'
    }
];
export default sidebarItem
