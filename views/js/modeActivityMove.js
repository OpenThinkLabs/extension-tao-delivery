// alert('ModeActivityMove loaded');

ModeActivityMove = [];
ModeActivityMove.tempId = '';
ModeActivityMove.originalPosition = [];

ModeActivityMove.on = function(activityId){
	//desactivate 'add activity' button(??)
	ActivityDiagramClass.currentMode = 'ModeActivityMove';
	
	//insert information in the feedback 'div'
	if(!ActivityDiagramClass.setFeedbackMenu('ModeActivityMove')){
		return false;
	}
	
	//determine if the object can be moved alone or not (typically, the first connector of...issue for a join connector that shares several previous activities);
	
	//save a temporary object the initial position of the activity in case of cancellation:
	var activity = ActivityDiagramClass.activities[activityId];
	ModeActivityMove.tempId = activityId;
	ModeActivityMove.originalPosition = activity.position;
	
	console.log(ArrowClass.arrows);
	//transform the activity to draggable (with itself as a helper opacity .7)
	var containerId = ActivityDiagramClass.getActivityId('container', activityId);
	if(!$('#'+containerId).length){
		throw 'The activity container '+containerId+' do not exists.';
	}
	$('#'+containerId).draggable({
		containment: ActivityDiagramClass.canvas,
		handle: '#'+ActivityDiagramClass.getActivityId('activity', activityId),
		scroll: true,
		drag: function(event, ui){
		
			console.log('position');console.dir($(this).position());
			console.log('offset');console.dir($(this).offset());
			
			//ondrag, update all connected arrows:
			
			//arrows that are connected to that activity:
			var activityBottomBorderPointId = ActivityDiagramClass.getActivityId('activity',activityId,'bottom');
			for(var arrowId in ArrowClass.arrows){
				var arrow = ArrowClass.arrows[arrowId];
				// console.dir(arrow);
				// console.dir(ModeActivityMove);
				if(arrow.targetObject == ModeActivityMove.tempId || arrowId == activityBottomBorderPointId){
					ArrowClass.arrows[arrowId] = ArrowClass.calculateArrow($('#'+arrowId), $('#'+arrow.target), arrow.type, new Array(), false);
					ArrowClass.redrawArrow(arrowId);
				}
			}
		}
	});
	
	return true;
}

ModeActivityMove.save = function(){
	console.log('ModeActivityMove.save:', 'not implemented yet');
	ModeActivityMove.cancel();
	
	
	
	//unquote section below when the communication with server is established:
	/*
	
	//send the coordinate + label to server
	//call processAuthoring/addActivity:
	
	//on success, delete the temp activity:
	ModeActivityAdd.cancel();
	
	//draw the real activity:
	positionData = 'positon of temp activity';
	activityData = [];
	newActivity = ActivityDiagramClass.feedActivity = function(activityData, positionData);//no need for array data since it is not connnected yet
	ActivityDiagramClass.drawActivity(newActivity.id);	
	*/
}

ModeActivityMove.cancel = function(){

	if(ActivityDiagramClass.currentMode == 'ModeActivityMove'){
		if(ModeActivityMove.tempId){
			var containerId = ActivityDiagramClass.getActivityId('container', ModeActivityMove.tempId);
			if(!$('#'+containerId).length){
				throw 'The activity container '+containerId+' do not exists.';
			}
			$('#'+containerId).draggable('destroy');
		}
	}
	
	//reset ActivityDiagramClass.setArrowMenuHandler(arrowId);//for each arrow that has been redrawn
	console.log(ActivityDiagramClass.currentMode);
	console.log(ModeActivityMove.tempId);
	console.log(containerId);
}