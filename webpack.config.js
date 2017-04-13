module.exports = {
	entry: {
		"match-detail": './app/js/match-detail.js',
		"match-overview": './app/js/match-overview.js'
	},
	output: {
		filename: './web/js/[name].js'
	},
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' for webpack 1
        }
    }
}
