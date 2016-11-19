[![Build Status](https://travis-ci.org/gungnir-mvc/Datasource.svg?branch=master)](https://travis-ci.org/gungnir-mvc/Datasource)
# Gungnir-MVC Datasource package

## Description
This package aims to help the separation of an application and it's data
sources by using a generic entrypoint interface which then communicates
further down into an adapter which then queries against a resource through
a driver which have been provided with it.

No matter what kind of _Adapter_ or _Driver_ you switch in into the _DataSource_
you should get the same response format back.

### DataSource
This is the main object that will be the entry communication point for
the application. 

### Adapter
This represents what kind of source the data is coming from. Two different alternatives
are a _Database_ or an _API_.

### Driver
This represents how a given adapter communicates with a source of a given type.
For _Database_ it could be for example _MySql_ or _Sqlite_ while an _API_ adapter
could use a _REST_ driver.