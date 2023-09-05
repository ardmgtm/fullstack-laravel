export const navItems = [
    {
        label: "Dashboard",
        href: "/",
        icon: "home"
    },
    {
        label: "Report",
        href: "/report",
        icon: "document-duplicate",
        submenu:[
            {
                label: "Daily",
                href: "/report/daily",
            },
            {
                label: "Monthly",
                href: "/report/monthly",
            },
            {
                label: "Annually",
                href: "/report/annually",
            },
        ]
    },
    {
        label: "Checkout",
        href: "/checkout",
        icon: "shopping-cart"
    },
];