"SELECT ls.SubLink_ID, 
						(SELECT input_current FROM `GAME_INPUT` 
							WHERE input_sublinkid = ls.SubLink_ID AND input_user=".$row->User_id." LIMIT 1) AS Current   
						FROM `GAME_LINKAGE_SUB` ls 
							LEFT OUTER JOIN GAME_SUBCOMPONENT s ON SubLink_SubCompID=s.SubComp_ID
							LEFT OUTER JOIN GAME_COMPONENT c on SubLink_CompID=c.Comp_ID
						WHERE SubLink_LinkID=".$linkid ." 
						ORDER BY SubLink_Order"
						
						
						
select ls.SubLink_ID, inp.input_current as Current FROM `GAME_LINKAGE_SUB` ls 
INNER JOIN GAME_INPUT inp ON  ls.SubLink_ID = inp.input_sublinkid
WHERE ls.SubLink_LinkID=29 and inp.input_user=134
UNION
select ls.SubLink_ID, outp.output_current as Current FROM `GAME_LINKAGE_SUB` ls 
INNER JOIN GAME_OUTPUT outp ON  ls.SubLink_ID = outp.output_sublinkid
WHERE ls.SubLink_LinkID=29 and outp.output_user=134 

ORDER BY SubLink_ID