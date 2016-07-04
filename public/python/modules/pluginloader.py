import os
import sys
import re
import importlib

def load_plugins():
    pysearchre = re.compile('.py$', re.IGNORECASE)
    pluginfiles = filter(pysearchre.search, os.listdir(os.path.join(os.path.dirname(__file__),'plugins')))
    print pluginfiles
                                                
    form_module = lambda fp: '.' + os.path.splitext(fp)[0]
    print form_module
    plugins = map(form_module, pluginfiles)
    print plugins
    # import parent module / namespace
    modules = []
    for plugin in plugins:
             if not plugin.startswith('__'):
                 modules.append(importlib.import_module(plugin, package="plugins"))

    return modules

load_plugins()
