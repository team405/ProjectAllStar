--RANK
select ans.contentID, ans.mobileUnum, ans.answerNum, min(ans.answerTimeStamp)-ques.startTimeStamp ansTime, user.mobileName 
from    dbsmaq.ansTime ans, dbsmaq.question ques, dbsmaq.mobileUser user
where   ans.answerTimeStamp between ques.startTimeStamp and (ques.startTimeStamp + ques.quesSec)
and     ans.contentId = ques.contentId
and     ques.contentId = '1'
and     ques.quesNum = '0'
and     ans.mobileUnum = user.mobileUnum
group by ans.contentID, ans.mobileUnum
having ans.answerNum = (select correctNum from dbsmaq.question where contentID = '1' and quesNum= '0')
order by ansTime

--ALLRANK
select a.mobileName,sum(a.ansTime) AS "回答時間", sum(a.counter) AS "正解数"
from dbsmaq.question q,
	(select '1' counter,ans.contentID, ans.mobileUnum, ans.answerNum, ques.quesNum, min(ans.answerTimeStamp)-ques.startTimeStamp ansTime, user.mobileName 
	from    dbsmaq.ansTime ans, dbsmaq.question ques, dbsmaq.mobileUser user
	where   ans.answerTimeStamp between ques.startTimeStamp and (ques.startTimeStamp + ques.quesSec)
	and     ans.contentId = ques.contentId
	and     ques.contentId = '1'
	and     ans.mobileUnum = user.mobileUnum
	group by ans.contentID, ans.mobileUnum, ques.quesNum
	order by ques.quesNum,ansTime) a
where q.quesNum = a.quesNum and a.answerNum = q.correctNum
group by a.mobileUnum
order by sum(a.counter) DESC, sum(a.ansTime)