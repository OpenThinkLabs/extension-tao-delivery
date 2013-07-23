function ItemVariableStorage(storageId) {
	this.storageId = storageId;
	this.variables = undefined;
	this.inSync = true;
	
	this.deliveryModule = window.location.pathname.replace(/^(.*\/)[^/]*/, "$1");
	
	if (typeof storageData !== "undefined" && storageData.serial == storageId) {
		this.variables = storageData.data;
	} else {
		this.load();
	}
}

ItemVariableStorage.prototype.get = function(key, callback){
	if (typeof callback == 'function') {
		callback(this.variables[key]);
	}
}

ItemVariableStorage.prototype.put = function(key, value){
	console.log('put key ' + key + ' value ' + value);
	this.variables[key] = value;
	this.inSync = false;
}

ItemVariableStorage.prototype.load = function(callback) {
	console.log('Loading data from ' + this.deliveryModule + 'getVariables');
	$.ajax({
		url  		: this.deliveryModule + 'getVariables',
		data 		: {
			id: this.storageId
		},
		type 		: 'post',
		dataType	: 'json',
		success		: function(reply) {
			if (reply.success) {
				this.variables = reply.data;
				this.inSync = true;
				if (typeof callback == "function") {
					callback();	
				}
			}
		}
	});
}

ItemVariableStorage.prototype.submit = function(callback) {

	console.log('Submited: ' + this.variables);
	if (this.inSync) {
		if (typeof callback == "function") {
			callback();
		}
	} else {
		$.ajax({
			url  		: this.deliveryModule + 'saveVariables',
			data 		: {
				id: this.storageId,
				data: this.variables
			},
			type 		: 'post',
			dataType	: 'json',
			success		: typeof callback == "function" ? callback : null
		});
	}
}