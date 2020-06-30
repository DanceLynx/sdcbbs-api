<p align="center"><h1>SDCBBS 闪电橙社区<h1></p>


## 项目介绍

这是一个基于laravel 6.0 框架的一个社区技术分享的社区问答系统，本项目适用于新手拿来参考，大神见了勿喷。

## 运行环境

> PHP 7.4
> MySQL 5.7 以上
> Redis 缓存服务
本项目是在Homestead开发的，最好最省事的办法就是你用的也是这个开发环境。

## 开发环境部署与安装
### 将代码拉到本地
```bash
git clone https://github.com/DanceLynx/sdcbbs.git
```

### 复制.env文件及依赖安装和密钥生成
```bash
$ cd sdcbbs
$ cp .env.example .env
$ composer install
$ php artisan key:generate
```

### 配置.env文件

```env
# 百度翻译配置
BAIDU_TRANSLATE_APPID=
BAIDU_TRANSLATE_KEY=
# 其他相关配置省略 包括数据库配置
```
最后就可以正常访问啦！

## 服务器架构说明

- Ubuutu 16.04 LTS Server
- [Laravel LNMP安装脚本](https://github.com/DanceLynx/laravel-ubuntu-init)
这样就可以快速搭建一个适用于线上的环境，详情查看脚本说明。

## 代码上线
需要关闭调试模式
然后各种缓存构建
```bash
# 构建路由缓存
$ php artisan route:cache

# 构建视图缓存
$ php artisan view:cache

# 构建配置缓存
$ php artisan config:cache

# 构建事件缓存
$ php artisan event:cache

```

## 扩展包说明
### 生产环境扩展包

| 扩展包 | 说明 |
|:----:|:----:|
|[guzzlehttp/guzzle](https://packagist.org/packages/guzzlehttp/guzzle)|HTTP 客户端请求库|
|[intervention/image](https://packagist.org/packages/intervention/image)|支持Laravel的图像处理及操作库|
|[laravel/horizon](https://packagist.org/packages/laravel/horizon)|Laravel队列的界面及代码配置的库|
|[mews/captcha](https://packagist.org/packages/mews/captcha)|Laravel 5 ~ 6 的验证码扩展包|
|[overtrue/laravel-lang](https://packagist.org/packages/overtrue/laravel-lang)|支持52种语言的语言包|
|[overtrue/pinyin](https://packagist.org/packages/overtrue/pinyin)|汉语拼音转换扩展包|
|[predis/predis](https://packagist.org/packages/predis/predis)|适用于PHP和HHVM的灵活且功能完善的Redis客户端|
|[spatie/laravel-permission](https://packagist.org/packages/spatie/laravel-permission)|支持Laravel 5.8 以上的权限处理库|
|[summerblue/administrator](https://packagist.org/packages/summerblue/administrator)|Laravel 的数据库接口包|
|[summerblue/laravel-active](https://packagist.org/packages/summerblue/laravel-active)|当前访问路径自动添加active属性|
|[viacreative/sudo-su](https://packagist.org/packages/viacreative/sudo-su)|可以一键切换其他用户的扩展包|

### 开发环境的扩展包(dev)

| 扩展包 | 说明 |
|:----:|:----:|
|[barryvdh/laravel-debugbar](https://packagist.org/packages/barryvdh/laravel-debugbar)|适用于Laravel的调试条|
|[barryvdh/laravel-ide-helper](https://packagist.org/packages/barryvdh/laravel-ide-helper)|Laravel IDE Helper为所有Facade类生成正确的PHP文档，以改善自动完成功能。|
|[summerblue/generator](https://packagist.org/packages/summerblue/generator)|一个支持Laravel的代码生成器|

## 自定义 Artisan 命令列表
- sdcbbs:calculate-active-user  生成活跃用户
- sdcbbs:sync-user-actived-at   将最后登录时间的用户数据从redis同步到数据库

## 队列列表
- TranslateSlug  话题slug生成队列