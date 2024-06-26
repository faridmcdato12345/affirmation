/* eslint-env node */
module.exports = {
  "root": true,
  "env": {
    "browser": true,
    "es2021": true,
    "node": true,
    "amd": true
  },
  "globals":
  {
    "Thenable": true,
    "NodeJS": true,
    "route": false
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
      "single"
    ],
    "semi": [
      "error",
      "never"
    ],
    "vue/multi-word-component-names": 0,
    "vue/no-multiple-template-root": "off",
    "vue/max-attributes-per-line": "off",
    "vue/require-default-prop": "off",
    "vue/no-reserved-component-names": ["error", {
      "disallowVueBuiltInComponents": false,
      "disallowVue3BuiltInComponents": false
    }],
    "vue/html-closing-bracket-newline": [
      "error", {
        "singleline": "never",
        "multiline": "never"
      }
    ],
    "vue/html-self-closing": ["error", {
      "html": {
        "void": "always",
        "normal": "never",
      },
      "svg": "always",
      "math": "always"
    }],
  },
}
