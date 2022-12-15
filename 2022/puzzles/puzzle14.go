package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"math"
	"strconv"
	"strings"
)

func stringToPoint(pointString string) point {
	pointComponents := strings.Split(pointString, ",")
	x, _ := strconv.Atoi(pointComponents[0])
	y, _ := strconv.Atoi(pointComponents[1])
	return point{x: x, y: y}
}

func lineToPoints(line string) []point {
	var points []point
	stringPoints := strings.Split(line, " -> ")
	for i := range stringPoints {
		currentPoint := stringToPoint(stringPoints[i])
		points = append(points, currentPoint)
		if i+1 >= len(stringPoints) {
			continue
		}
		nextPoint := stringToPoint(stringPoints[i+1])
		var direction string
		var distance int
		if currentPoint.x != nextPoint.x {
			direction = "x"
			distance = nextPoint.x - currentPoint.x
		} else {
			direction = "y"
			distance = nextPoint.y - currentPoint.y
		}
		for delta := 1; delta < int(math.Abs(float64(distance))); delta++ {
			if direction == "x" {
				if distance > 0 {
					points = append(points, point{x: currentPoint.x + delta, y: currentPoint.y})
				} else {
					points = append(points, point{x: currentPoint.x - delta, y: currentPoint.y})
				}
			} else {
				if distance > 0 {
					points = append(points, point{x: currentPoint.x, y: currentPoint.y + delta})
				} else {
					points = append(points, point{x: currentPoint.x, y: currentPoint.y - delta})
				}
			}
		}
	}
	return points
}

func pointsToCaveMap(points []point, isPart2 bool) [][]int {
	var maxX int
	var maxY int
	for _, point := range points {
		if point.x > maxX {
			maxX = point.x
		}
		if point.y > maxY {
			maxY = point.y
		}
	}
	maxX += 115
	if isPart2 {
		maxY += 2
	}
	caveMap := make([][]int, maxY+1)
	for i := range caveMap {
		caveMap[i] = make([]int, maxX+1)
	}
	for _, point := range points {
		caveMap[point.y][point.x] = 1
	}
	if isPart2 {
		for x := range caveMap[len(caveMap)-1] {
			caveMap[len(caveMap)-1][x] = 1
		}
	}
	return caveMap
}

func runPuzzle14Part1() {
	lines := common.GetInputLines("day14.txt", false)
	var points []point
	for _, line := range lines {
		points = append(points, lineToPoints(line)...)
	}
	caveMap := pointsToCaveMap(points, false)

	currentUnit := 1
	currentPoint := point{x: 500, y: 0}
	for {
		if currentPoint.y >= len(caveMap)-1 || currentPoint.x >= len(caveMap[currentPoint.y]) {
			break
		}
		if caveMap[currentPoint.y+1][currentPoint.x] == 0 {
			currentPoint.y += 1
		} else if caveMap[currentPoint.y+1][currentPoint.x-1] == 0 {
			currentPoint.y += 1
			currentPoint.x -= 1
		} else if currentPoint.x+1 >= len(caveMap[currentPoint.y+1]) || caveMap[currentPoint.y+1][currentPoint.x+1] == 0 {
			currentPoint.y += 1
			currentPoint.x += 1
		} else {
			caveMap[currentPoint.y][currentPoint.x] = 2
			currentUnit++
			currentPoint = point{x: 500, y: 0}
		}
	}
	fmt.Println("Sand flowed into abyss after:", currentUnit-1)
}

func runPuzzle14Part2() {
	lines := common.GetInputLines("day14.txt", false)
	var points []point
	for _, line := range lines {
		points = append(points, lineToPoints(line)...)
	}
	caveMap := pointsToCaveMap(points, true)

	currentUnit := 1
	currentPoint := point{x: 500, y: 0}
	for {
		if caveMap[currentPoint.y+1][currentPoint.x] == 0 {
			currentPoint.y += 1
		} else if caveMap[currentPoint.y+1][currentPoint.x-1] == 0 {
			currentPoint.y += 1
			currentPoint.x -= 1
		} else if currentPoint.x+1 >= len(caveMap[currentPoint.y+1]) || caveMap[currentPoint.y+1][currentPoint.x+1] == 0 {
			currentPoint.y += 1
			currentPoint.x += 1
		} else {
			caveMap[currentPoint.y][currentPoint.x] = 2
			currentUnit++
			if currentPoint.y == 0 && currentPoint.x == 500 {
				break
			}
			currentPoint = point{x: 500, y: 0}
		}
	}
	fmt.Println("Sand blocked the source after:", currentUnit-1)
}

func RunPuzzle14() {
	log.Println("--- STARTING PUZZLE 14 ---")
	runPuzzle14Part1()
	runPuzzle14Part2()
	log.Println("--- FINISHED PUZZLE 14 ---")
}
