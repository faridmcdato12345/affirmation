module.exports = {
  "root": true,
  "env": {
    "browser": true,
    "es2021": true
  },
  "extends": [
    "eslint:recommended",
    "plugin:vue/recommended"
  ],
  "parserOptions": {
    "ecmaVersion": 12,
    "sourceType": "module"
  },
  "plugins": [
    "vue"
  ],
  "rules": {
    "indent": [
      "error",
      2
    ],
    "linebreak-style": [
      "error",
      "unix"
    ],
    "quotes": [
      "error",
      "double"
    ],
    "semi": [
      "error",
      "never"
    ],
    "vue/multi-word-component-names": 0,
    "vue/max-attributes-per-line": "off",
    "vue/require-default-prop": "off",
    "vue/no-reserved-component-names": ["error", {
      "disallowVueBuiltInComponents": false,
      "disallowVue3BuiltInComponents": false
    }]
  }
}
