#!/usr/bin/env python3
#
# Copyright 2011 CPD
    

import tornado.httpserver
import tornado.ioloop
import tornado.options
import tornado.web
import tornado.escape
import time
import datetime
import os
import random
import socket
import json


class UploadHandler(tornado.web.RequestHandler):
    def post(self):
        self.write(self.render_string('header.html'))
        client_filepath =  tornado.escape.xhtml_escape(self.get_argument("file.path"))
        print(client_filepath)
        client_filetype =  tornado.escape.xhtml_escape(self.get_argument("file.content_type"))
        client_filename =  tornado.escape.xhtml_escape(self.get_argument("file.name"))
        client_filesize =  tornado.escape.xhtml_escape(self.get_argument("file.size"))
        self.write(self.render_string('demo.html',path=client_filepath,mime=client_filetype,name=client_filename,size=client_filesize))
        self.write(self.render_string('footer.html'))  
        os.remove(client_filepath)
        
def main():

    tornado.options.parse_command_line()
    # timeout in seconds
    timeout = 10
    socket.setdefaulttimeout(timeout)

    
    settings = {
        "static_path": os.path.join(os.path.dirname(__file__), "static"),
        "xsrf_cookies": False,
        "template_path" : "templates",
        "autoescape" : "xhtml_escape"
    }
    application = tornado.web.Application([
        (r"/.*" ,UploadHandler),
        
    ], **settings)
    
    http_server = tornado.httpserver.HTTPServer(application)
    http_server.listen(8080)
    tornado.ioloop.IOLoop.instance().start()


if __name__ == "__main__":
    main()
