VERSION = "1.0.3"
VERSION2 = $(shell echo $(VERSION)|sed 's/ /-/g')
PKG = pkg_jofacebook
ZIPFILE = $(PKG)-$(VERSION2).zip
UPDATEFILE = update_pkg.xml
MKFILE_PATH := $(abspath $(lastword $(MAKEFILE_LIST)))
MKFILE_DIR := $(dir $(MKFILE_PATH))
ROOT = $(shell pwd)

# Only set DATE if you need to force the date.  
# (Otherwise it uses the current date.)
# DATE = "February 19, 2011"

all: parts $(ZIPFILE) fixsha

INSTALLS = jofbkpost_plugin \
	   jofbkineditor_plugin \
	   com_jofacebook

EXTRAS = 

NAMES = $(INSTALLS) $(EXTRAS)

ZIPS = $(NAMES:=.zip)

ZIPIGNORES = -x "*.git*" -x -x Makefile -x "*.sh" 

parts: $(ZIPS)

%.zip:
	@echo "-------------------------------------------------------"
	@echo "Creating zip file for: $*"
	@rm -f $@
	@(cd $*; zip -r ../$@ * $(ZIPIGNORES))

$(ZIPFILE): $(ZIPS)
	@echo "-------------------------------------------------------"
	@echo "Creating extension zip file: $(ZIPFILE)"
	@mv $(INSTALLS:=.zip) $(PKG)/packages/
	@(cd  $(PKG); zip -r ../$@ * $(ZIPIGNORES))
	@echo "-------------------------------------------------------"
	@echo "Finished creating package $(ZIPFILE)."


fixversions:
	@echo "Updating all install xml files to version $(VERSION)"
	@find . \( -name '*.xml' ! -name 'default.xml' ! -name 'metadata.xml' ! -name 'config.xml' \) -exec  ./fixvd.sh {} $(VERSION) \;

revertversions:
	@echo "Reverting all install xml files"
	@find . \( -name '*.xml' ! -name 'default.xml' ! -name 'metadata.xml' ! -name 'config.xml' \) -exec git checkout {} \;

fixsha:
	@echo "Updating update xml files with checksums"
	@(cd $(ROOT);./fixsha.sh $(ZIPFILE) $(UPDATEFILE))

untabify:
	@find . -name '*.php' -exec $(MKFILE_DIR)/replacetabs.sh {} \;



