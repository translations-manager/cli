cli
===

## Configuration file

At the root of the project
```yaml
# .translations_manager.yml

server:
    host: http://api.translate.local # API host
    port: 80
    username: test
    password: test
project_id: 1
format: json # The format of the translation files. Can also be "xlf". Or "yml" but the push is not implemented yet
```

## Commands

```bash
trmg pull # Retrieve the translations from the cloud
trmg push # Push the local translations to the cloud
```
