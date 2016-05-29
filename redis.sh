#install homebrew
/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
#install wget
brew install wget
#install redis
wget http://download.redis.io/redis-stable.tar.gz
tar xvzf redis-stable.tar.gz
cd redis-stable
make
#configure redis
mkdir /etc/redis
mkdir /var/redis
cp utils/redis_init_script /etc/init.d/redis_6379
touch /etc/init.d/redis_6379
cp redis.conf /etc/redis/6379.conf
mkdir /var/redis/6379
update-rc.d redis_6379 defaults
#run redis
/etc/init.d/redis_6379 start