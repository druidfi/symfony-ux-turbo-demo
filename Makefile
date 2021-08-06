.PHONY: start stop

start:
	symfony local:run --daemon yarn encore dev --watch
	symfony local:server:start --daemon

stop:
	symfony local:server:stop
