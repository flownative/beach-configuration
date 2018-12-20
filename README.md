# Beach Configuration

This package provides parsing and validation for the Beach configuration files (.beach.yaml).

As an example, the following YAML source can be converted to an object structure as follows:
```yaml
builder:
  gitStrategy: 'clone'
  steps:
    build-composer:
      type: docker
      image: 'flownative/composer:7.2'
      script:
        - composer --no-dev -o -v --no-progress --ignore-platform-reqs install
        - echo "${BEACH_BUILD_COMMIT_TAG}" > BeachBuildVersion

    build-assets:
      type: docker
      image: 'flownative/node-build-tools:1'
      script:
        - nvm install 4.4.2
        - nvm use 4.4.2
        - cd $BEACH_BUILD_DIRECTORY/Packages/Application/Neos.MarketPlace
        - npm install
        - cd $BEACH_BUILD_DIRECTORY/Packages/Sites/Neos.NeosIo
        - npm install
        - npm run build
        - npm run minify
```

```php
$configuration = Configuration::fromYamlSource($yamlSource);

# Show a list of command lines:
$commandLines = $configuration->builder()->steps[0]->script();
echo (implode("\n", $commandLines);
```
