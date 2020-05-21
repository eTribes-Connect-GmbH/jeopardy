module.exports = {
    'extends': 'standard',
    'root': true,
    'env': {
        'browser': true
    },
    'globals': {
        'PluginManager': true,
        'Shopware': true
    },
    "parser": "babel-eslint",
    'parserOptions': {
        'ecmaVersion': 2016
    },
    'rules': {
        'arrow-parens': 0,
        'space-before-function-paren': 0,
        'consistent-this': ['error'],
        'keyword-spacing': [
            'warn'
        ],
        'padded-blocks': [
            'warn'
        ],
        'space-in-parens': [
            'warn'
        ],
        'generator-star-spacing': 0,
        'no-shadow-restricted-names': 0,
        'eqeqeq': 0,
        'no-debugger': 0,
        'semi': [
            'error',
            'always'
        ],
        'one-var': [
            'error',
            'never'
        ],
        'indent': [
            'error',
            4
        ],
        'standard/no-callback-literal': 0
    }
};
