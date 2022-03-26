default: info
info:
	@echo "--------------------------------------------------------------------------------"
	@echo "--------------------------- RM MANAGER MAKE COMMANDS ---------------------------"
	@echo "--------------------------------------------------------------------------------"
	@echo "-------------------------- SYMFONY COMMANDS --------------------------"
	@echo "make back         -> Start symfony server"
	@echo "--------------------------- INTERFACE COMMANDS ---------------------------"
	@echo "make front       -> Start vite dev server"

back:
	@./api/symfony serve

front:
	@npm run dev --prefix app
