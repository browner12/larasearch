# LaraSearch Documentation

## Config Setup

Your `larasearch.php` configuration file is well-documented and only contains a handful of values you may need to adjust. It comes preset with sensible defaults.

### Driver

Currently the only supported driver is 'elasticsearch'. If you would like to support anther driver, we are more than happy to look at Pull Requests!

### Index

While the name if your index is not incredibly important, a common value is the name of your application.

### Search Hosts and Search Connections

Connections are the way your application accesses the search provider. If your search provider lives on the same server as the application, the `localhost` connection will probably meet your needs. Different search providers may have different connection setups. You may add any key/value pair that is relevant to your search provider connection. The `hosts` property allows you to choose which connections to actually use when we instantiate the searcher. Depending on the search provider, you may be able to have multiple connections open at once.

### Searchable Models

Add the names of the models in your application that implement the `Searchable` interface. This allows the `IndexCommand` to automatically add all of your `Searchable` models to the index with one Artisan command. You do not **need** to use this feature if you do not want to. 

### Queue

Larasearch makes it *incredibly* easy to queue the indexing operations of the `SearchObserver`. You have full control to index at any of the operations we monitor with the observer. If any of these values are `true`, we will create a queued `Job` when the observer picks up on a change, rather than executing the search operation immediately.


### Tubes

You may also specify which queue tube your jobs will run on. This is a good way to have different priority jobs that can be assigned different resources.

## Model Setup

To make your models compatible with the Larasearch package, you only need to implement the `Searchable` interface, and use the `CanBeSearched` trait. The interface helps ensure we have access to the methods we need to get your content stored in the index correctly. The trait provides some sensible defaults, and also registers our `SearchObserver`, which automatically updates the index when your model is changed. You may override these methods if desired.

The `getSearchType` method provides us with the name of the type of model we are indexing. By default we will use the class name of the model. The `getSearchId` method gives us the unique ID of the model. By default we will use the `$model->getKey()` result. Finally, the `getSearchContent` method gives us the data from the model that you actually want indexed and searchable. By default we will use `$model->toArray()`.
 
 ```php
 class User extends Model implements Searchable
 {
     use CanBeSearched;
     
     public function getSearchType(){}
     
     public function getSearchId(){}
     
     public function getSearchContent(){}
 }
 ```

## Next Steps

Once you have completed the setup, read more about [INDEXING](indexing.md) and [SEARCHING](searching.md).

## Upgrading

If you are upgrading to v1, please read the [UPGRADE GUIDE](upgrading-to-v1.md).
