#---------------------------
# This script generates a new force-first-last.pot file for use in translations.
# To generate a new force-first-last.pot, cd to the main /force-first-last/ directory,
# then execute `languages/gettext.sh` from the command line.
# then fix the header info (helps to have the old force-first-last.pot open before running script above)
# then execute `cp languages/force-first-last.pot languages/force-first-last.po` to copy the .pot to .po
# then execute `msgfmt languages/force-first-last.po --output-file languages/force-first-last.mo` to generate the .mo
#---------------------------
echo "Updating paid-memberships-pro.pot... "
xgettext -j -o languages/force-first-last.pot \
--default-domain=force-first-last \
--language=PHP \
--keyword=_ \
--keyword=__ \
--keyword=_e \
--keyword=_ex \
--keyword=_n \
--keyword=_x \
--keyword=esc_html__ \
--keyword=esc_html_e \
--keyword=esc_html_x \
--keyword=esc_attr__ \
--keyword=esc_attr_e \
--keyword=esc_attr_x \
--sort-by-file \
--package-version=1.0 \
--msgid-bugs-address="info@strangerstudios.com" \
$(find . -name "*.php")
echo "Done!"