import Vue from 'vue';


Vue.filter('dateTimeformat',(arg)=>{
	return new Date(arg).toLocaleString()
})

Vue.filter('dateformat', (arg)=>{
	return new Date(arg).toLocaleDateString()
})

Vue.filter('timeformat', (arg)=>{
	return new Date(arg).toLocaleTimeString()
})

Vue.filter('capitalize', (arg)=>{
	if (!arg) return ''
  	arg = arg.toString()
  	return arg.charAt(0).toUpperCase() + arg.slice(1)
})