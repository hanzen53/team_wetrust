Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'dlt-master-file',
            path: '/dlt-master-file',
            component: require('./components/Tool'),
        },
    ])
})
