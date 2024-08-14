import {
    CircleIcon,
    TypographyIcon,
    HexagonIcon,
    KeyIcon,
    BugIcon,
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
    },
    {
        title: 'Authentication',
        icon: KeyIcon,
        name: 'root',
        children: [
            {
                title: 'Login',
                icon: CircleIcon,
                name: 'root.test' //any one child root name required to same of parent root name
            },
            {
                title: 'Register',
                icon: CircleIcon,
                name: 'root.test.two' //any one child root name required to same of parent root name
            }
        ]
    },
    {
        title: 'Test',
        icon: HexagonIcon,
        name: 'main',
        children: [
            {
                title: 'Login',
                icon: CircleIcon,
                name: 'main.test' //any one child root name required to same of parent root name
            },
            {
                title: 'Register',
                icon: CircleIcon,
                name: 'main.test.two' //any one child root name required to same of parent root name
            }
        ]
    },
    {
        title: 'Error 404',
        icon: BugIcon,
        name: 'error'
    },
    {
        title: 'Typography',
        icon: TypographyIcon,
        name: 'typography'
    }
];
export default sidebarItem
