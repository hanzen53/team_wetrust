Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'device-offline',
            path: '/device-offline',
            component: require('./components/Tool'),
        },
    ])
})
