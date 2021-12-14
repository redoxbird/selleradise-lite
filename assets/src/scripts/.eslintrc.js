module.exports = {
  parser: "@babel/eslint-parser",
  parserOptions: {
    sourceType: "module",
    allowImportExportEverywhere: false,
    requireConfigFile: false,
    ecmaFeatures: {
      globalReturn: false,
    },
    babelOptions: {
      configFile: false,
    },
  },
};
