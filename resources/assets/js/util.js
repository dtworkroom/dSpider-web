/**
 * Created by du on 16/12/8.
 */

module.exports={
    log:console.log.bind(console),
    handle(success,fail){
        return function (data) {
            //需要登录
            if (data.code == -10) {
                location = "./login"
            } else if (data.code == 0) {
                success=success||module.exports.log
                success(data.data)
            } else {
                if (fail) {
                    fail(data.msg)
                } else {
                    alert(data, msg);
                }
            }
        }
    }
}

