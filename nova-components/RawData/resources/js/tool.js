Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'raw-data',
            path: '/raw-data',
            component: require('./components/Tool'),
        },
    ])
})
