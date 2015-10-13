# Documentation for the log module

## toggleDebug(BOOL)

Toggles if debug output should be printed to stdout.

## log_function(STRING, INT)

Default function for output. You should _not_ use this function, because it is
only used internal. The string is the log message and int is the number of the
loglevel.

### Loglevel:

* 0 - Debug
* 1 - Print
* 2 - Warning
* 3 - Error

Error causes the exit of the program, so only use it on _critical_ problems!

## Logging Functions

All of the following functions have the argument, a STRING as log message. They
are used to call `log_function` with the right loglevel.

### Log(STRING)

Loglevel 0

### Print(STRING)

Loglevel 1

### Warn(STRING)

Loglevel 2

### Error(STRING)

Loglevel 3
