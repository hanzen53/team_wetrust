Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'imei-status',
            path: '/imei-status',
            component: require('./components/Tool'),
        },
    ])
})
