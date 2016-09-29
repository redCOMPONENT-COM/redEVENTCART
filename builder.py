#! /usr/bin/env python3
import re
import os
import shutil
import argparse
import fileinput
import sys
import fnmatch

class RedextensionWizard:
    """"create utility for joomla"""
    def __init__(self, component, destination):
        self.base = "."
        self.component = component
        self.destination = destination

    def export(self):
        print('exporting ', self.component, ' to ', self.destination)
        # git export
        os.system('git checkout-index -a -f --prefix=' + self.destination + '/')
        self._replace_filename()
        self._replace_content()
        os.chdir(self.destination)
        os.system('git init')
        os.system('git submodule add git@github.com:redCOMPONENT-COM/redCORE.git build/redCORE')
        os.system('cd extensions/components/com_' + self.component + '/libraries/' + self.component + ' && composer dump-autoload')
        os.system('cd build && npm install')
        print('done')

    def _replace_filename(self):
        for path, subdirs, files in os.walk(self.destination):
            for fname in files:
                if('redeventcart' in fname):
                    os.rename(os.path.join(path, fname), os.path.join(path,
                        fname.replace('redeventcart', self.component)))
        for path, subdirs, files in os.walk(self.destination, topdown=False):
            for fname in subdirs:
                if('redeventcart' in fname):
                    os.rename(os.path.join(path, fname), os.path.join(path,
                        fname.replace('redeventcart', self.component)))

    def _replace_content(self):
        for path, dirs, files in os.walk(os.path.abspath(self.destination)):
            for filename in files:
                if filename.lower().endswith(('.jpg', '.png', '.phar')):
                    continue
                filepath = os.path.join(path, filename)
                print(filepath)
                with open(filepath) as f:
                    s = f.read()
                s = self._case_sensitive_replace(s, 'redeventcart', self.component)
                with open(filepath, "w") as f:
                    f.write(s)

    def _case_sensitive_replace(self, string, old, new):
        """ replace occurrences of old with new, within string
            replacements will match the case of the text it replaces
        """
        def repl(match):
            current = match.group()
            result = ''
            all_upper=True
            for i,c in enumerate(current):
                if i >= len(new):
                    break
                if c.isupper():
                    result += new[i].upper()
                else:
                    result += new[i].lower()
                    all_upper=False
            #append any remaining characters from new
            if all_upper:
                result += new[i+1:].upper()
            else:
                result += new[i+1:].lower()
            return result

        regex = re.compile(re.escape(old), re.I)
        return regex.sub(repl, string)

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description='Create redCORE extension')
    parser.add_argument('-c', '--component', required=True, help='the component name')
    parser.add_argument('-d', '--destination', required=True, help='the folder where to export the component repo')

    args = parser.parse_args()
    x = RedextensionWizard(args.component, args.destination)
    x.export()
