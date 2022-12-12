package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"sort"
	"strconv"
	"strings"
)

type monkey struct {
	items              []int
	operator           string
	operationAmount    int
	testDivideBy       int
	throwToIfTestOk    int
	throwToIfTestNotOk int
	throws             int
}

func linesToMonkey(lines []string, startOffset int) monkey {
	var startingItems []int
	for _, item := range strings.Split(strings.Split(lines[startOffset+1], ": ")[1], ", ") {
		intValue, _ := strconv.Atoi(item)
		startingItems = append(startingItems, intValue)
	}
	operationSlice := strings.Split(lines[startOffset+2], " ")
	operator := operationSlice[len(operationSlice)-2]
	operationAmount, err := strconv.Atoi(operationSlice[len(operationSlice)-1])
	if err != nil {
		operationAmount = -1
	}
	testBySlice := strings.Split(lines[startOffset+3], " ")
	testDivideBy, _ := strconv.Atoi(testBySlice[len(testBySlice)-1])
	testTrueSlice := strings.Split(lines[startOffset+4], " ")
	throwToIfTestOk, _ := strconv.Atoi(testTrueSlice[len(testTrueSlice)-1])
	testFalseSlice := strings.Split(lines[startOffset+5], " ")
	throwToIfTestNotOk, _ := strconv.Atoi(testFalseSlice[len(testFalseSlice)-1])
	return monkey{items: startingItems, operator: operator, operationAmount: operationAmount, testDivideBy: testDivideBy,
		throwToIfTestOk: throwToIfTestOk, throwToIfTestNotOk: throwToIfTestNotOk, throws: 0}
}

func executeOperation(item int, monkey monkey) int {
	amount := monkey.operationAmount
	if amount == -1 {
		amount = item
	}
	if monkey.operator == "*" {
		return item * amount
	} else {
		return item + amount
	}
}

func runPuzzle11Part1() {
	lines := common.GetInputLines("day11.txt", false)
	var monkeys []monkey
	for i := 0; i < len(lines); i += 7 {
		monkeys = append(monkeys, linesToMonkey(lines, i))
	}

	rounds := 20
	for i := 0; i < rounds; i++ {
		for i, monkey := range monkeys {
			for _, item := range monkey.items {
				newWorryValue := executeOperation(item, monkey)
				newWorryValue = newWorryValue / 3
				if newWorryValue%monkey.testDivideBy == 0 {
					monkeys[monkey.throwToIfTestOk].items = append(monkeys[monkey.throwToIfTestOk].items, newWorryValue)
				} else {
					monkeys[monkey.throwToIfTestNotOk].items = append(monkeys[monkey.throwToIfTestNotOk].items, newWorryValue)
				}
				monkeys[i].throws++
			}
			monkeys[i].items = []int{}
		}
	}
	sort.SliceStable(monkeys, func(i, j int) bool {
		return monkeys[i].throws > monkeys[j].throws
	})
	fmt.Println("Monkey business:", monkeys[0].throws*monkeys[1].throws)
}

func runPuzzle11Part2() {
	lines := common.GetInputLines("day11.txt", false)
	var monkeys []monkey
	group := 1
	for i := 0; i < len(lines); i += 7 {
		monkey := linesToMonkey(lines, i)
		monkeys = append(monkeys, monkey)
		group *= monkey.testDivideBy
	}

	rounds := 10000
	for i := 0; i < rounds; i++ {
		for j, monkey := range monkeys {
			for _, item := range monkey.items {
				newWorryValue := executeOperation(item, monkey)
				newWorryValue %= group
				if newWorryValue%monkey.testDivideBy == 0 {
					monkeys[monkey.throwToIfTestOk].items = append(monkeys[monkey.throwToIfTestOk].items, newWorryValue)
				} else {
					monkeys[monkey.throwToIfTestNotOk].items = append(monkeys[monkey.throwToIfTestNotOk].items, newWorryValue)
				}
				monkeys[j].throws++
			}
			monkeys[j].items = []int{}
		}
	}
	sort.SliceStable(monkeys, func(i, j int) bool {
		return monkeys[i].throws > monkeys[j].throws
	})
	fmt.Println("Monkey business:", monkeys[0].throws*monkeys[1].throws)
}

func RunPuzzle11() {
	log.Println("--- STARTING PUZZLE 11 ---")
	runPuzzle11Part1()
	runPuzzle11Part2()
	log.Println("--- FINISHED PUZZLE 11 ---")
}
