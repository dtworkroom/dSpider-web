/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.l = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// identity function for calling harmory imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };

/******/ 	// define getter function for harmory exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		Object.defineProperty(exports, name, {
/******/ 			configurable: false,
/******/ 			enumerable: true,
/******/ 			get: getter
/******/ 		});
/******/ 	};

/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};

/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports) {

eval("/**\n * Created by du on 16/12/8.\n */\n\nmodule.exports={\n    log:console.log.bind(console),\n    handle: function handle(success,fail){\n        return function (data) {\n            //需要登录\n            if (data.code == -10) {\n                location = \"./login\"\n            } else if (data.code == 0) {\n                success=success||module.exports.log\n                success(data.data)\n            } else {\n                if (fail) {\n                    fail(data.msg)\n                } else {\n                    alert(data, msg);\n                }\n            }\n        }\n    }\n}\n\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL3V0aWwuanM/YTg0MCJdLCJzb3VyY2VzQ29udGVudCI6WyIvKipcbiAqIENyZWF0ZWQgYnkgZHUgb24gMTYvMTIvOC5cbiAqL1xuXG5tb2R1bGUuZXhwb3J0cz17XG4gICAgbG9nOmNvbnNvbGUubG9nLmJpbmQoY29uc29sZSksXG4gICAgaGFuZGxlKHN1Y2Nlc3MsZmFpbCl7XG4gICAgICAgIHJldHVybiBmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgICAgICAgLy/pnIDopoHnmbvlvZVcbiAgICAgICAgICAgIGlmIChkYXRhLmNvZGUgPT0gLTEwKSB7XG4gICAgICAgICAgICAgICAgbG9jYXRpb24gPSBcIi4vbG9naW5cIlxuICAgICAgICAgICAgfSBlbHNlIGlmIChkYXRhLmNvZGUgPT0gMCkge1xuICAgICAgICAgICAgICAgIHN1Y2Nlc3M9c3VjY2Vzc3x8bW9kdWxlLmV4cG9ydHMubG9nXG4gICAgICAgICAgICAgICAgc3VjY2VzcyhkYXRhLmRhdGEpXG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgIGlmIChmYWlsKSB7XG4gICAgICAgICAgICAgICAgICAgIGZhaWwoZGF0YS5tc2cpXG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgYWxlcnQoZGF0YSwgbXNnKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICB9XG59XG5cblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyByZXNvdXJjZXMvYXNzZXRzL2pzL3V0aWwuanMiXSwibWFwcGluZ3MiOiJBQUFBOzs7O0FBSUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Iiwic291cmNlUm9vdCI6IiJ9");

/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

eval("/**\n * Created by du on 16/12/8.\n */\nvar util=__webpack_require__(0)\n//测试log\nutil.log(\"xx\")\nvar prefix=\"api/\"\nfunction addScript(){\n    $.post(prefix+\"profile/spider/save\",{\n        name:\"test\",\n        content:\"dSpider(\\\"test\\\", function(session,env,$) {\\r\\nlog(session)\\r\\n})\" ,\n        startUrl:\"https://www.baidu.com\"\n    }).done(util.handle())\n}\nfunction addAppKey(){\n    $.post(prefix+\"profile/appkey/save\",{\n        name:\"小赢卡带\"\n    }).done(util.handle())\n}\n\n\n$(\"#spiders\").click(function(){\n    $.post(prefix+\"spiders\")\n        .done(util.handle())\n})//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMS5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2FwaVRlc3QuanM/MWQ2YyJdLCJzb3VyY2VzQ29udGVudCI6WyIvKipcbiAqIENyZWF0ZWQgYnkgZHUgb24gMTYvMTIvOC5cbiAqL1xudmFyIHV0aWw9cmVxdWlyZShcIi4vdXRpbC5qc1wiKVxuLy/mtYvor5Vsb2dcbnV0aWwubG9nKFwieHhcIilcbnZhciBwcmVmaXg9XCJhcGkvXCJcbmZ1bmN0aW9uIGFkZFNjcmlwdCgpe1xuICAgICQucG9zdChwcmVmaXgrXCJwcm9maWxlL3NwaWRlci9zYXZlXCIse1xuICAgICAgICBuYW1lOlwidGVzdFwiLFxuICAgICAgICBjb250ZW50OlwiZFNwaWRlcihcXFwidGVzdFxcXCIsIGZ1bmN0aW9uKHNlc3Npb24sZW52LCQpIHtcXHJcXG5sb2coc2Vzc2lvbilcXHJcXG59KVwiICxcbiAgICAgICAgc3RhcnRVcmw6XCJodHRwczovL3d3dy5iYWlkdS5jb21cIlxuICAgIH0pLmRvbmUodXRpbC5oYW5kbGUoKSlcbn1cbmZ1bmN0aW9uIGFkZEFwcEtleSgpe1xuICAgICQucG9zdChwcmVmaXgrXCJwcm9maWxlL2FwcGtleS9zYXZlXCIse1xuICAgICAgICBuYW1lOlwi5bCP6LWi5Y2h5bimXCJcbiAgICB9KS5kb25lKHV0aWwuaGFuZGxlKCkpXG59XG5cblxuJChcIiNzcGlkZXJzXCIpLmNsaWNrKGZ1bmN0aW9uKCl7XG4gICAgJC5wb3N0KHByZWZpeCtcInNwaWRlcnNcIilcbiAgICAgICAgLmRvbmUodXRpbC5oYW5kbGUoKSlcbn0pXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIHJlc291cmNlcy9hc3NldHMvanMvYXBpVGVzdC5qcyJdLCJtYXBwaW5ncyI6IkFBQUE7OztBQUdBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOyIsInNvdXJjZVJvb3QiOiIifQ==");

/***/ }
/******/ ]);