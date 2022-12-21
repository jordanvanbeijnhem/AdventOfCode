package puzzles

import (
	"2022/common"
	"encoding/json"
	"log"
)

func runPuzzle13Part1() {
	lines := common.GetInputLines("day13.txt", true)
	var myStoredVariable []any
	json.Unmarshal([]byte(lines[3]), &myStoredVariable)

	//var result []any
	//for _, r := range lines[3] {
	//	//str := string(r)
	//	outerIndex := 0
	//	if r == '[' {
	//
	//	}
	//	if r != '[' && r != ',' && r != ' ' && r != ']' {
	//		fmt.Println(string(r))
	//	}
	//}
}
func RunPuzzle13() {
	log.Println("--- STARTING PUZZLE 13 ---")
	runPuzzle13Part1()
	log.Println("--- FINISHED PUZZLE 13 ---")
}
