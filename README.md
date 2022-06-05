# Calculator Project

To get the project up and running, execute the following on the command line (in the root dir):
```
make setup
```
Note: this should only be called once.

To shut down the project run:
```
make stop
```
Note: To start up the project again run `make start`

If the project was setup correctly you can go to:

```
http://localhost:8080/
```

You should see:

![Site](https://gcdnb.pbrd.co/images/T5mgLSqEmbCP.png)


To run the tests call:
```
make php-run-tests
```

To list all available options run:
```
make
```

## TODOs

- Create more tests for the compiler
- Add a lexer to have something that generate symbols that could possibly be cached
- Use redis for general caching
