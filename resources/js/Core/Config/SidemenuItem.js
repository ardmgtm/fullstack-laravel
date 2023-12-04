export const navItems = [
    {
        label: "Dashboard",
        href: "/dashboard",
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
        label: "Master Data",
        href: "/master",
        icon: "square-3-stack-3d",
        submenu:[
            {
                label: "Data 1",
                href: "/master/data-1",
            },
            {
                label: "Data 2",
                href: "/master/data-2",
            },
        ]
    },
    {
        label: "User Management",
        href: "/users",
        icon: "users",
        submenu:[
            {
                label: "User",
                href: "/user",
            },
            {
                label: "Role & Permission",
                href: "/role-and-permission",
            },
            {
                label: "User Log",
                href: "/user-log",
            },
        ]
    },
];