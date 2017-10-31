var Browser = {};
//页面
Browser.Page = (function () {
  return {
    scrollTop: function () {
      return Math.max(document.body.scrollTop, document.documentElement.scrollTop);
    },
    scrollLeft: function () {
      return Math.max(document.body.scrollLeft, document.documentElement.scrollLeft);
    },
    height: function () {
      var _height;
      if (document.compatMode == "CSS1Compat") {
        _height = document.documentElement.scrollHeight;
      } else {
        _height = document.body.scrollHeight;
      }
      return _height;
    },
    width: function () {
      var _width;
      if (document.compatMode == "CSS1Compat") {
        _width = document.documentElement.scrollWidth;
      } else {
        _width = document.body.scrollWidth;
      }
      return _width;
    }
  };
})();

//窗口：
Browser.Window = (function () {
  return {
    outerHeight: function () {
      var _hei = window.outerHeight;
      if (typeof _hei != "number") {
        _hei = Browser.ViewPort.outerHeight();
      }
      return _hei;
    },
    outerWidth: function () {
      var _wid = window.outerWidth;
      if (typeof _wid != "number") {
        _wid = Browser.ViewPort.outerWidth();
      }
      return _wid;
    },
    innerHeight: function () {
      var _hei = window.innerHeight;
      if (typeof _hel != "number") {
        _hei = Browser.ViewPort.innerHeight();
      }
      return _hei;
    },
    innerWidth: function () {
      var _wid = window.innerWidth;
      if (typeof _wid != "number") {
        _wid = Browser.ViewPort.innerWidth();
      }
      return _wid;
    },
    height: function () {
      return Browser.Window.innerHeight();
    },
    width: function () {
      return Browser.Window.innerWidth();
    }
  }
})();

//视口:
Browser.ViewPort = (function () {
  return {
    innerHeight: function () {
      var _height;
      if (document.compatMode == "CSS1Compat") {
        _height = document.documentElement.clientHeight;
      } else {
        _height = document.body.clientHeight;
      }
      return _height;
    },
    innerWidth: function () {
      var _width;
      if (document.compatMode == "CSS1Compat") {
        _width = document.documentElement.clientWidth;
      } else {
        _width = document.body.clientWidth;
      }
      return _width;
    },
    outerHeight: function () {
      var _height;
      if (document.compatMode == "CSS1Compat") {
        _height = document.documentElement.offsetHeight;
      } else {
        _height = document.body.offsetHeight;
      }
      return _height;
    },
    outerWidth: function () {
      var _width;
      if (document.compatMode == "CSS1Compat") {
        _width = document.documentElement.offsetWidth;
      } else {
        _width = document.body.offsetWidth;
      }
      return _width;
    },
    width: function () {
      return Browser.ViewPort.innerWidth();
    },
    height: function () {
      return Browser.ViewPort.innerHeight();
    }
  }
})();