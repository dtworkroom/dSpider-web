import "./common/TweenLite.min.js";
import "./common/graph.js";
(function() {
    var width, height, canvas, ctx, points, target, animateHeader = true;
    var time=10000;
    // Main
    initHeader();
    initAnimation();
    addListeners();

    function initHeader() {

        canvas = document.getElementById('spider-canvas');
        canvas.width = width=$(canvas).parent().width();
        canvas.height = height=$(canvas).parent().outerHeight();
        console.log(height)
        target = {x: width/2, y: height/2};
        ctx = canvas.getContext('2d');

        // create points
        points = [];

        var sec=25
        var closetPoints=5;

        if(width<480){
            sec=10
            closetPoints=5;
            time=16000;
        }
        for(var x = 0; x < width; x = x + width/sec) {
            var tempHeight=height>width?height:height;
            for(var y = 0; y < tempHeight; y = y + tempHeight/sec) {
                var px = x + Math.random()*width/sec;
                var py = y + Math.random()*tempHeight/sec;
                var p = {x: px, originX: px, y: py, originY: py };
                points.push(p);
            }
        }

        // for each point find the 5 closest points
        for(var i = 0; i < points.length; i++) {
            var closest = [];
            var p1 = points[i];
            for(var j = 0; j < points.length; j++) {
                var p2 = points[j]
                if(!(p1 == p2)) {
                    var placed = false;
                    for(var k = 0; k < closetPoints; k++) {
                        if(!placed) {
                            if(closest[k] == undefined) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }
                    for(var k = 0; k < closetPoints; k++) {
                        if(!placed) {
                            if(getDistance(p1, p2) < getDistance(p1, closest[k])) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }
                }
            }
            p1.closest = closest;
        }

        // assign a circle to each point
        for(var i in points) {
            var c = new Circle(points[i], 2+Math.random()*2, 'rgba(255,255,255,0.3)');
            points[i].circle = c;
        }
    }

    // Event handling
    function addListeners() {
        if(!('ontouchstart' in window)) {
            $(canvas).parent().on('mousemove', mouseMove);

        }
        $(canvas).parent()[0].addEventListener("touchstart",mouseMove,true);
        window.addEventListener('scroll', scrollCheck);
        window.addEventListener('resize', resize);
    }

    function mouseMove(e) {
        if(e.touches){
            //if()
            target.x= e.touches[0].pageX
            target.y=e.touches[0].pageY-$(this).offset().top
        }else {
            target.x = e.clientX;
            target.y= e.pageY-$(this).offset().top;
            //console.log(target)
        }
    }

    function scrollCheck() {
        animateHeader = true;
    }

    function resize() {
        canvas.width =width= $(canvas).parent().width();
        canvas.height =height= $(canvas).parent().height();
    }

    // animation
    function initAnimation() {
        animate();
        for(var i in points) {
            shiftPoint(points[i]);
        }
    }

    function animate() {
        if(animateHeader) {
            ctx.clearRect(0,0,width,height);
            for(var i in points) {
                // detect points in range
                if(Math.abs(getDistance(target, points[i])) < 4000) {
                    points[i].active = 0.3;
                    points[i].circle.active = 0.6;
                } else if(Math.abs(getDistance(target, points[i])) < 20000) {
                    points[i].active = 0.1;
                    points[i].circle.active = 0.3;
                } else if(Math.abs(getDistance(target, points[i])) < 40000) {
                    points[i].active = 0.02;
                    points[i].circle.active = 0.1;
                } else {
                    points[i].active = 0;
                    points[i].circle.active = 0;
                }

                drawLines(points[i]);
                points[i].circle.draw();
            }
        }
        requestAnimationFrame(animate);
    }

    var direct=true;

    var last=new Date().getTime();
    var per=width/time;
    function shiftPoint(p) {
        TweenLite.to(p, 1+1*Math.random(), {x:p.originX-50+Math.random()*100,
            y: p.originY-50+Math.random()*100,
            onComplete: function() {
                //if(width>720) {
                //    var now = new Date().getTime()
                //    var delta = per * (now - last)
                //    last = now;
                //    if (direct) {
                //        if (target.x >= width) {
                //            direct = false;
                //            target.x -= delta;
                //        } else {
                //            target.x += delta;
                //        }
                //    } else {
                //        if (target.x <= 0) {
                //            direct = true;
                //            target.x += delta;
                //        } else {
                //            target.x -= delta;
                //        }
                //    }
                //
                //    target.y = (Math.sin(target.x / width * 6.28) * height / 2) * (direct ? -1 : 1) + height / 2;
                //}
                shiftPoint(p);
            }});
    }

    // Canvas manipulation
    function drawLines(p) {
        if(!p.active) return;
        for(var i in p.closest) {
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            ctx.lineTo(p.closest[i].x, p.closest[i].y);
            ctx.strokeStyle = 'rgba(156,217,249,'+ p.active+')';
            ctx.stroke();
        }
    }

    function Circle(pos,rad,color) {
        var _this = this;

        // constructor
        (function() {
            _this.pos = pos || null;
            _this.radius = rad || null;
            _this.color = color || null;
        })();

        this.draw = function() {
            if(!_this.active) return;
            ctx.beginPath();
            ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
            ctx.fillStyle = 'rgba(156,217,249,'+ _this.active+')';
            ctx.fill();
        };
    }
    // Util
    function getDistance(p1, p2) {
        return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
    }

})();