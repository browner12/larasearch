# LaraSearch Documentation

Now the fun part... actually searching for documents!

## Basic Search

A basic search will use the entire index, and return all relevant documents to you.

```php
$searcher->search('query');
```

## Type Search

You may also limit your search to a particular type.

```php
$searcher->searchType(App\User::class, 'query');
```

## Autocomplete

Finally, autocomplete works on partial matches, and can be used to build instant search results.

```php
$searcher->autocomplete('query');
```

## Next Steps

Congrats! You have finished reading the documentation. You are now ready to add search to your website!

Or, if you need a refresher, check out the docs some more.

[SETUP](readme.md)
[ELASTICSEARCH](elasticsearch.md)
[INDEXING](indexing.md)
[SEARCHING](searching.md)
