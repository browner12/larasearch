# LaraSearch Documentation

The first step to using Larasearch is indexing your documents. This can be done with a couple of simple methods. All of the following example will assume you have either manually instantiated one of the implementations, or using Laravel's dependency injection to create a `Searcher`.

## Creating

To index a `Searchable` model, pass it to the `create` method.

```php
$user = User::find(1);

$searcher->create($user);
```

## Updating

To update a `Searchable` model, pass it to the `update` method. Depending on the driver, we may pass it back to the `create` method if the document does not already exist in the index. In this sense, the `update` method can be treated as an 'upsert'.

```php
$user = User::find(1);

$searcher->update($user);
```

## Deleting

To delete a `Searchable` model, pass it to the `delete` method.

```php
$user = User::find(1);

$searcher->delete($user);
```

## Bulk Updates

You may also index a `Collection` of `Searchable` models all at once. If the driver supports it, you may chunk the operation to help prevent memory issues. A sensible default of 1000 is used, but you may set that with the second parameter.

```php
$users = User::all();

$searcher->bulk($users, 1000);
```

## Next Steps

Once you indexed your documents, now it's time to start [SEARCHING](searching.md) them.
