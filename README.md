Encode / Decode ([Download v1.10](https://raw.github.com/willfarrell/alfred-encode-decode-workflow/master/encode-decode.alfredworkflow))
=====================

Encoding and decoding a string into multiple variations.

## Requirements
1. [Alfred App v2](http://www.alfredapp.com/#download)
1. [Alfred Powerpack](https://buy.alfredapp.com/)

## Installing
1. Click the download buttons below
2. Double-click to import into Alfred 2
3. Review the workflow to add custom Hotkeys

### macOS Monterey (12.0) compatibility

Starting in macOS Monterey, there won't be any PHP runtime (which is required for this workflow) bundle with the OS, find more info in [#23](https://github.com/willfarrell/alfred-encode-decode-workflow/issues/23).

To Solve this issue, follow these steps:

1. Install Homebrew with the command provided on its [homepage](https://brew.sh/)
2. Install PHP runtime with Homebrew

```shell
brew install php
```

3. Head to setting page of this Alfred workflow, double-click on encode / decode block, and change `php` to `/usr/local/bin/php`.

## Updating
Run the [Alleyoop Workflow](http://www.alfredforum.com/topic/1582-alleyoop-update-alfred-workflows/) using the keyword `oop`. If you're not comfortable with Alleyoop, **star & watch this repo** to keep up to date on new versions and additional workflows.

## About
Will transform your query strings through *base64*, *html*, *url*, and *utf-8* encode/decode. Pressing enter will copy the encoded/decoded string to the clipboard.

![alt text][encode]

![alt text][decode]

## Commands
- `encode {query}` - Encode magic
- `decode {query}` - Decode magic

## Contributors
- [@willfarrell](https://github.com/willfarrell)
- [@cvn](https://github.com/cvn)

## Mentions
- [15 Alfred Workflows to Turbocharge Productivity](http://www.bachyaproductions.com/15-alfred-workflows-turbocharge-productivity/)


[encode]: ./screenshots/encode.png "Encode"
[decode]: ./screenshots/decode.png "Decode"
